<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if(Auth::check()){ 
            return redirect('/dashboard');
        }
        
        // Get all levels for the register form
        $levels = LevelModel::all();
        return view('auth.login', compact('levels'));
    }

    public function postlogin(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                return response()->json([
                'status' => true,
                'message' => 'Login Berhasil',
                'redirect' => url('/dashboard')
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal',
                'msgField' => ['username' => ['Username atau password salah']]
            ]);
        }
        return redirect('login');
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|string|min:6|confirmed',
            ]);
    
            // Set default level_id to 4 (customer)
            UserModel::create([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => Hash::make($request->password),
                'level_id' => 4 // Default to customer (level_id 4)
            ]);
    
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}