<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index()
    {
        $userLevel = Auth::user()->level->level_kode;
        $activeMenu = 'dashboard';
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'list' => ['Home', 'Dashboard']
        ];
        
        if ($userLevel == 'CUS') {
            return $this->customerDashboard($breadcrumb, $activeMenu);
        } elseif (in_array($userLevel, ['MNG', 'STF'])) {
            return $this->staffDashboard($breadcrumb, $activeMenu);
        } else { 
            return $this->adminDashboard($breadcrumb, $activeMenu);
        }
    }
    
    private function customerDashboard($breadcrumb, $activeMenu)
    {
        $userId = Auth::id();
        
        $recentTransactions = PenjualanModel::where('user_id', $userId)
            ->orderBy('penjualan_tanggal', 'desc')
            ->limit(5)
            ->get();
            
        $totalTransactions = PenjualanModel::where('user_id', $userId)->count();
        
        $totalSpent = PenjualanDetailModel::join('t_penjualan', 't_penjualan.penjualan_id', '=', 't_penjualan_detail.penjualan_id')
            ->where('t_penjualan.user_id', $userId)
            ->sum(DB::raw('t_penjualan_detail.harga * t_penjualan_detail.jumlah'));
            
        $mostPurchased = PenjualanDetailModel::join('t_penjualan', 't_penjualan.penjualan_id', '=', 't_penjualan_detail.penjualan_id')
            ->join('m_barang', 'm_barang.barang_id', '=', 't_penjualan_detail.barang_id')
            ->where('t_penjualan.user_id', $userId)
            ->select('m_barang.barang_nama', DB::raw('SUM(t_penjualan_detail.jumlah) as total_qty'))
            ->groupBy('m_barang.barang_nama')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();
            
        $monthlyData = PenjualanModel::where('user_id', $userId)
            ->whereYear('penjualan_tanggal', Carbon::now()->year)
            ->select(
                DB::raw('MONTH(penjualan_tanggal) as month'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        $chartData = [];
        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];
        
        foreach ($monthNames as $num => $name) {
            $found = false;
            foreach ($monthlyData as $data) {
                if ($data->month == $num) {
                    $chartData[] = [
                        'month' => $name,
                        'total' => $data->total_orders
                    ];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $chartData[] = [
                    'month' => $name,
                    'total' => 0
                ];
            }
        }
        
        return view('dashboard.customer', compact(
            'breadcrumb',
            'activeMenu',
            'recentTransactions',
            'totalTransactions',
            'totalSpent',
            'mostPurchased',
            'chartData'
        ));
    }
    
    private function staffDashboard($breadcrumb, $activeMenu)
    {
        $totalProducts = BarangModel::count();
        
        $totalSuppliers = SupplierModel::count();
        
        $lowStockProducts = BarangModel::whereHas('stok', function($query) {
            $query->select('barang_id')
                ->groupBy('barang_id')
                ->havingRaw('SUM(stok_jumlah) < 10');
        })->count();
            
        $recentProducts = BarangModel::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $topProducts = PenjualanDetailModel::join('m_barang', 'm_barang.barang_id', '=', 't_penjualan_detail.barang_id')
            ->select(
                'm_barang.barang_nama',
                DB::raw('SUM(t_penjualan_detail.jumlah) as total_qty')
            )
            ->groupBy('m_barang.barang_nama')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();
            
        $productsByCategory = BarangModel::join('m_kategori', 'm_kategori.kategori_id', '=', 'm_barang.kategori_id')
            ->select(
                'm_kategori.kategori_nama',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('m_kategori.kategori_nama')
            ->get();
            
        $categoryNames = $productsByCategory->pluck('kategori_nama')->toArray();
        $categoryTotals = $productsByCategory->pluck('total')->toArray();
            
        return view('dashboard.staff', compact(
            'breadcrumb',
            'activeMenu',
            'totalProducts',
            'totalSuppliers',
            'lowStockProducts',
            'recentProducts',
            'topProducts',
            'categoryNames',
            'categoryTotals'
        ));
    }
    
    private function adminDashboard($breadcrumb, $activeMenu)
    {
        $usersByLevel = UserModel::join('m_level', 'm_level.level_id', '=', 'm_user.level_id')
            ->select(
                'm_level.level_nama',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('m_level.level_nama')
            ->get();
            
        $totalBarang = BarangModel::count();

        $totalSuppliers = SupplierModel::count();

        $recentUsers = UserModel::join('m_level', 'm_level.level_id', '=', 'm_user.level_id')
            ->select('m_user.*', 'm_level.level_nama')
            ->orderBy('m_user.created_at', 'desc')
            ->limit(5)
            ->get();
            
        $totalUsers = UserModel::count();
        
        $totalTransactions = PenjualanModel::count();
        
        $recentTransactions = PenjualanModel::with('user')
            ->orderBy('penjualan_tanggal', 'desc')
            ->limit(5)
            ->get();
            
        $monthlyRegistrations = UserModel::whereYear('created_at', Carbon::now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        $chartData = [];
        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];
        
        foreach ($monthNames as $num => $name) {
            $found = false;
            foreach ($monthlyRegistrations as $data) {
                if ($data->month == $num) {
                    $chartData[] = [
                        'month' => $name,
                        'total' => $data->total
                    ];
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $chartData[] = [
                    'month' => $name,
                    'total' => 0
                ];
            }
        }
        
        $levelNames = $usersByLevel->pluck('level_nama')->toArray();
        $levelTotals = $usersByLevel->pluck('total')->toArray();
        
        return view('dashboard.admin', compact(
            'breadcrumb',
            'activeMenu',
            'totalBarang',
            'totalSuppliers',
            'totalUsers',
            'totalTransactions',
            'recentTransactions',
            'chartData',
            'levelNames',
            'levelTotals',
            'recentUsers'
        ));
    }
}