<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        $levels = LevelModel::all();
        return view('auth.register', compact('levels'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|string|min:6|confirmed',
                'level_id' => 'required|exists:m_level,level_id'
            ]);
    
            UserModel::create([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => Hash::make($request->password),
                'level_id' => $request->level_id
            ]);
    
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }
}
