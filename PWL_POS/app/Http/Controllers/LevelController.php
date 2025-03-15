<?php

namespace App\Http\Controllers;

use Monolog\Level;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use App\DataTables\LevelDataTable;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index(LevelDataTable $dataTable)
    {
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values (?, ?, ?)', ['CUS', 'Pelanggan', now()]);
        // return 'Insert data baru berhasil';

        // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
        // return 'Update data berhasil. Jumlah data yang diupdate ' . $row . " baris";

        // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
        // return 'Delete data berhasil. Jumlah data yang dihapus ' . $row . " baris";

        // $data = DB::select('select * from m_level');
        // return view('level', ['data' => $data]);

        return $dataTable->render('level.index');
    }

    public function create() {
        return view('level.form');
    }

    public function store(Request $request) {
        LevelModel::create([
            'level_kode' => $request->kodeLevel,
            'level_nama' => $request->namaLevel,
        ]);
        return redirect('/level');
    }
}
