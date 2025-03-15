<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        // $data = [
        //     'username' => 'customer-1',
        //     'nama' => 'Pelanggan',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 4
        // ];
        // UserModel::insert($data);

        // $data = [
        //     'nama' => 'Pelanggan Pertama',
        // ];
        // UserModel::where('username', 'customer-1')->update($data);

        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345'),
        // ];
        // UserModel::create($data);

        // $user = UserModel::find(1);

        // $user = UserModel::where('level_id', 1)->first();

        // $user = UserModel::firstWhere('level_id', 1);

        // $user = UserModel::findOr(20, ['username', 'nama'], function () {
        //     abort(404);
        // });

        // $user = UserModel::findOrFail(1);

        // $user = UserModel::where('username', 'manager-9')->firstOrFail();

        // $user = UserModel::where('level_id', 2)->count();
        // dd($user);

        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ]
        // );

        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager22',
        //         'nama' => 'Manager Dua Dua',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ]
        // );
        
        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ]
        // );

        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ]
        // );

        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ]
        // );
        // $user->save();

        // $user = UserModel::create([
        //     'username' => 'manager55',
        //     'nama' => 'Manager55',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2
        // ]);
        
        // $user->username = 'manager56';
        
        // $user->isDirty();
        // $user->isDirty('username');
        // $user->isDirty('nama');
        // $user->isDirty(['nama', 'username']);
        
        // $user->isClean();
        // $user->isClean('username');
        // $user->isClean('nama');
        // $user->isClean(['nama', 'username']);
        
        // $user->save();
        
        // $user->isDirty();
        // $user->isClean();
        // dd($user->isDirty());

        // $user = UserModel::create([
        //     'username' => 'manager11',
        //     'nama' => 'Manager11',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2
        // ]);
        
        // $user->username = 'manager12';

        // $user->save();

        // $user->wasChanged();
        // $user->wasChanged('username');
        // $user->wasChanged(['username', 'level_id']);
        // $user->wasChanged('nama');
        // dd($user->wasChanged(['nama', 'username']));
        // $user = UserModel::all();
        // $user = UserModel::with('level')->get();
        // dd($user);

        // // $user = UserModel::all();
        // return view('user', ['data' => $user]);
        return $dataTable->render('user.user');
    }

    public function create()
    {
        $levels = LevelModel::all();
        return view('user.form', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_id' => 'required|exists:m_level,level_id',
            'username' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'password' => 'required|string',
        ]);

        UserModel::create([
            'level_id' => $request->level_id,
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat');
    }

    public function edit($id)
    {
        $user = UserModel::find($id);
        $levels = LevelModel::all();
        return view('user.form', compact('user', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make('$request->password');
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/users');
    }

    public function destroy($id)
    {
        $user = UserModel::find($id);
        $user->delete();
        
        return redirect('/users');
    }
}
