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
        // Check if user is customer or admin/manager/staff
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
        // Get customer's orders
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
        
        // Check if user is authorized to view this order
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

    // Checkout method for customers to create a new order from cart
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

    // Process the order after checkout
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
            
            // Create penjualan details and update stock
            foreach ($cart as $id => $item) {
                $barang = BarangModel::findOrFail($id);
                
                // Check stock availability
                $stockAvailable = StokModel::where('barang_id', $id)->sum('stok_jumlah');
                
                if ($stockAvailable < $item['quantity']) {
                    throw new \Exception('Stok tidak mencukupi untuk produk: ' . $barang->barang_nama);
                }
                
                // Create detail record
                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $id,
                    'harga' => $barang->harga_jual,
                    'jumlah' => $item['quantity']
                ]);
                
                // Reduce stock (creating a negative stock entry)
                StokModel::create([
                    'barang_id' => $id,
                    'user_id' => Auth::id(),
                    'stok_tanggal' => now(),
                    'stok_jumlah' => -$item['quantity']
                ]);
            }
            
            // Clear the cart
            session()->forget('cart');
            
            DB::commit();
            return redirect('/penjualan/' . $penjualan->penjualan_id)->with('success', 'Pemesanan berhasil dibuat');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    // For admin to create a new transaction
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

    // For admin to store a new transaction
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
            
            // Create penjualan header
            $penjualanKode = 'TRX-' . date('YmdHis') . '-' . Auth::id();
            $penjualan = PenjualanModel::create([
                'user_id' => Auth::id(),
                'pembeli' => $request->pembeli,
                'penjualan_kode' => $penjualanKode,
                'penjualan_tanggal' => now()
            ]);
            
            // Create penjualan details and update stock
            foreach ($request->barang_id as $key => $barangId) {
                $barang = BarangModel::findOrFail($barangId);
                $jumlah = $request->jumlah[$key];
                
                // Check stock availability
                $stockAvailable = StokModel::where('barang_id', $barangId)->sum('stok_jumlah');
                
                if ($stockAvailable < $jumlah) {
                    throw new \Exception('Stok tidak mencukupi untuk produk: ' . $barang->barang_nama);
                }
                
                // Create detail record
                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $barangId,
                    'harga' => $barang->harga_jual,
                    'jumlah' => $jumlah
                ]);
                
                // Reduce stock (creating a negative stock entry)
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
}