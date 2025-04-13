<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\BarangModel;
use App\Models\StokModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function index()
    {
        if (Auth::user()->level->level_kode == 'CUS') {
            return $this->customerPenjualanView();
        } else {
            return $this->staffPenjualanView();
        }
    }

    private function staffPenjualanView()
    {
        $penjualan = PenjualanModel::with('user')->get();
        $breadcrumb = (object) [
            'title' => 'Data Penjualan',
            'list' => ['Home', 'Penjualan']
        ];
        $activeMenu = 'penjualan'; 
        
        return view('penjualan.index', compact('breadcrumb', 'activeMenu', 'penjualan'));
    }

    private function customerPenjualanView()
    {
        $penjualan = PenjualanModel::with('detail')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        $breadcrumb = (object) [
            'title' => 'Riwayat Pembelian',
            'list' => ['Home', 'Pembelian']
        ];
        $activeMenu = 'penjualan';
        
        return view('penjualan.customer_index', compact('breadcrumb', 'activeMenu', 'penjualan'));
    }

    public function list(Request $request)
    {
        $query = PenjualanModel::with('user');
        
        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('tanggal', function($data) {
                return Carbon::parse($data->penjualan_tanggal)->format('d/m/Y');
            })
            ->addColumn('total', function($data) {
                return 'Rp ' . number_format($this->calculateTotal($data->penjualan_id), 0, ',', '.');
            })
            ->addColumn('aksi', function($data) {
                $buttons = '<div class="btn-group">';
                $buttons .= '<a href="' . url('/penjualan/' . $data->penjualan_id) . '" class="btn btn-xs btn-info mr-1"><i class="fa fa-eye"></i></a>';
                $buttons .= '</div>';
                return $buttons;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    private function calculateTotal($penjualanId)
    {
        $details = PenjualanDetailModel::where('penjualan_id', $penjualanId)->get();
        $total = 0;
        
        foreach ($details as $detail) {
            $total += $detail->harga * $detail->jumlah;
        }
        
        return $total;
    }

    public function show($id)
    {
        $penjualan = PenjualanModel::with(['user', 'detail.barang'])->findOrFail($id);
        
        if (Auth::user()->level->level_nama == 'CST' && $penjualan->user_id != Auth::id()) {
            return redirect('/penjualan')->with('error', 'Anda tidak berhak melihat data ini');
        }
        
        $breadcrumb = (object) [
            'title' => 'Detail Penjualan',
            'list' => ['Home', 'Penjualan', 'Detail']
        ];
        $activeMenu = 'penjualan';
        
        return view('penjualan.show', compact('breadcrumb', 'activeMenu', 'penjualan'));
    }

    public function checkout()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect('/stok')->with('error', 'Keranjang belanja kosong');
        }
        
        $breadcrumb = (object) [
            'title' => 'Checkout',
            'list' => ['Home', 'Keranjang', 'Checkout']
        ];
        $activeMenu = 'stok';
        
        return view('penjualan.checkout', compact('breadcrumb', 'activeMenu', 'cart'));
    }

    public function process(Request $request)
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect('/stok')->with('error', 'Keranjang belanja kosong');
        }
        
        try {
            DB::beginTransaction();
            
            $penjualanKode = 'TX' . date('ymd') . Auth::id() . substr(uniqid(), -4);
            $penjualan = PenjualanModel::create([
                'user_id' => Auth::id(),
                'pembeli' => Auth::user()->nama,
                'penjualan_kode' => $penjualanKode,
                'penjualan_tanggal' => now()
            ]);
            
            foreach ($cart as $id => $item) {
                $barang = BarangModel::findOrFail($id);
                
                $stockAvailable = StokModel::where('barang_id', $id)->sum('stok_jumlah');
                
                if ($stockAvailable < $item['quantity']) {
                    throw new \Exception('Stok tidak mencukupi untuk produk: ' . $barang->barang_nama);
                }
                
                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $id,
                    'harga' => $barang->harga_jual,
                    'jumlah' => $item['quantity']
                ]);
                
                StokModel::create([
                    'barang_id' => $id,
                    'user_id' => Auth::id(),
                    'stok_tanggal' => now(),
                    'stok_jumlah' => -$item['quantity']
                ]);
            }
            
            session()->forget('cart');
            
            DB::commit();
            return redirect('/penjualan/' . $penjualan->penjualan_id)->with('success', 'Pemesanan berhasil dibuat');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $barang = BarangModel::with(['kategori', 'stok'])->get();
        $breadcrumb = (object) [
            'title' => 'Tambah Penjualan',
            'list' => ['Home', 'Penjualan', 'Tambah']
        ];
        $activeMenu = 'penjualan';
        
        return view('penjualan.create', compact('breadcrumb', 'activeMenu', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembeli' => 'required|string|max:100',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:m_barang,barang_id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|numeric|min:1'
        ]);
        
        try {
            DB::beginTransaction();
            
            $penjualanKode = 'TX' . date('ymd') . Auth::id() . substr(uniqid(), -4);
            $penjualan = PenjualanModel::create([
                'user_id' => Auth::id(),
                'pembeli' => Auth::user()->nama,
                'penjualan_kode' => $penjualanKode,
                'penjualan_tanggal' => now()
            ]);
            
            foreach ($request->barang_id as $key => $barangId) {
                $barang = BarangModel::findOrFail($barangId);
                $jumlah = $request->jumlah[$key];
                
                $stockAvailable = StokModel::where('barang_id', $barangId)->sum('stok_jumlah');
                
                if ($stockAvailable < $jumlah) {
                    throw new \Exception('Stok tidak mencukupi untuk produk: ' . $barang->barang_nama);
                }
                
                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $barangId,
                    'harga' => $barang->harga_jual,
                    'jumlah' => $jumlah
                ]);
                
                StokModel::create([
                    'barang_id' => $barangId,
                    'user_id' => Auth::id(),
                    'stok_tanggal' => now(),
                    'stok_jumlah' => -$jumlah
                ]);
            }
            
            DB::commit();
            return redirect('/penjualan/' . $penjualan->penjualan_id)->with('success', 'Penjualan berhasil dibuat');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat penjualan: ' . $e->getMessage());
        }
    }

    public function export_pdf()
    {
        ini_set('max_execution_time', 300);

        $penjualan = PenjualanModel::with(['user', 'detail.barang'])
                    ->orderBy('penjualan_tanggal', 'desc')
                    ->get();

        $penjualan->map(function($item) {
            $total = 0;
            foreach ($item->detail as $detail) {
                $total += $detail->harga * $detail->jumlah;
            }
            $item->total_penjualan = $total;
            return $item;
        });

        $imagePath = public_path('/images/polinema.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('penjualan.export_pdf', [
            'penjualan' => $penjualan,
            'logoSrc' => $imageSrc
        ]);
        
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Penjualan '.date('Y-m-d H:i:s').'.pdf');
    }
}