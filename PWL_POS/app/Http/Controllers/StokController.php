<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    public function index()
    {
        if (Auth::user()->level->level_kode == 'CUS') {
            return $this->customerStokView();
        } else {
            return $this->staffStokView();
        }
    }

    private function staffStokView()
    {
        $barang = BarangModel::with('kategori')->get();
        $breadcrumb = (object) [
            'title' => 'Data Stok',
            'list' => ['Home', 'Stok']
        ];
        $activeMenu = 'stok'; 
        return view('stok.index', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu,
            'barang' => $barang  
        ]);
    }
    
    private function customerStokView()
    {
        $barang = BarangModel::with(['kategori', 'stok'])
            ->whereHas('stok', function($query) {
                $query->where('stok_jumlah', '>', 0);
            })
            ->get();
        $breadcrumb = (object) [
            'title' => 'Data Stok',
            'list' => ['Home', 'Stok']
        ];
        $activeMenu = 'stok'; 
        return view('stok.customer', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu,
            'barang' => $barang  
        ]);
    }

    public function list(Request $request)
    {
        $query = StokModel::with(['barang', 'user']);
            // ->where('stok_jumlah', '>', 0); 
        
        if ($request->filter_barang) {
            $query->where('barang_id', $request->filter_barang);
        }
    
        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function($data) {
                $buttons = '<div class="btn-group">';
                $buttons .= '<button onclick="editStok(' . $data->stok_id . ')" class="btn btn-xs btn-info mr-1"><i class="fa fa-edit"></i></button>';
                $buttons .= '<button onclick="modalAction(\''.url('/stok/' . $data->stok_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                $buttons .= '</div>';
                return $buttons;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $barang = BarangModel::whereNotIn('barang_id', function($query) {
            $query->select('barang_id')->from('t_stok');
        })->get();

        return view('stok.create_ajax', ['barang' => $barang]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'barang_id' => 'required|integer|exists:m_barang,barang_id|unique:t_stok,barang_id',
                'stok_jumlah' => 'required|integer|min:1',
            ], [
                'barang_id.unique' => 'Barang ini sudah memiliki stok. Harap hapus stok lama terlebih dahulu untuk menambahkan stok baru.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ]);
            }

            $stok = StokModel::create([
                'barang_id' => $request->barang_id,
                'user_id' => auth()->user()->user_id,
                'stok_tanggal' => now(),
                'stok_jumlah' => $request->stok_jumlah
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Stok berhasil ditambahkan'
            ]);
        }
        return redirect('/');
    }

    public function confirm_ajax($id)
    {
        $stok = StokModel::with(['barang', 'user'])->find($id);
        return view('stok.confirm_ajax', ['stok' => $stok]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            
            if ($stok) {
                try {
                    $stok->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Stok berhasil dihapus'
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Gagal menghapus stok: ' . $e->getMessage()
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Stok tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }


    // public function store_ajax(Request $request)
    // {
    //     try {
    //         DB::beginTransaction();
            
    //         $request->validate([
    //             'barang_id' => 'required|exists:m_barang,barang_id',
    //             'stok_jumlah' => 'required|numeric|min:1',
    //         ]);
            
    //         StokModel::create([
    //             'barang_id' => $request->barang_id,
    //             'user_id' => Auth::id(),
    //             'stok_tanggal' => now(),
    //             'stok_jumlah' => $request->stok_jumlah,
    //         ]);
            
    //         DB::commit();
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Stok berhasil ditambahkan'
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Gagal menambahkan stok: ' . $e->getMessage()
    //         ]);
    //     }
    // }

    public function edit_ajax($id)
    {
        $stok = StokModel::findOrFail($id);
        $barang = BarangModel::all();
        return view('stok.edit_ajax', compact('stok', 'barang'));
    }

    public function update_ajax(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'stok_jumlah' => 'required|numeric'
            ]);
            
            $stok = StokModel::findOrFail($id);
            $stok->update([
                'stok_jumlah' => $request->stok_jumlah,
                'updated_at' => now()
            ]);
            
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Stok berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate stok: ' . $e->getMessage()
            ]);
        }
    }

    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'barang_id' => 'required|exists:m_barang,barang_id',
                'quantity' => 'required|numeric|min:1'
            ]);
            
            $barang = BarangModel::findOrFail($request->barang_id);
            $availableStock = StokModel::where('barang_id', $request->barang_id)
                ->sum('stok_jumlah');
            
            if ($availableStock < $request->quantity) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi');
            }
            
            $cart = session()->get('cart', []);
            
            if (isset($cart[$request->barang_id])) {
                $cart[$request->barang_id]['quantity'] += $request->quantity;
            } else {
                $cart[$request->barang_id] = [
                    'barang_nama' => $barang->barang_nama,
                    'barang_kode' => $barang->barang_kode,
                    'harga' => $barang->harga_jual,
                    'quantity' => $request->quantity
                ];
            }
            
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan ke keranjang: ' . $e->getMessage());
        }
    }

    public function viewCart()
    {
        $breadcrumb = (object) [
            'title' => 'Data Stok',
            'list' => ['Home', 'Stok']
        ];
        $activeMenu = 'stok'; 
        return view('stok.cart', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu,
        ]);
    }

    public function export_pdf()
    {
        ini_set('max_execution_time', 300);

        $stok = StokModel::with(['barang.kategori', 'user'])
                    ->orderBy('stok_tanggal', 'desc')
                    ->get();

        $imagePath = public_path('/images/polinema.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('stok.export_pdf', [
            'stok' => $stok,
            'logoSrc' => $imageSrc
        ]);
        
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Stok '.date('Y-m-d H:i:s').'.pdf');
    }
}