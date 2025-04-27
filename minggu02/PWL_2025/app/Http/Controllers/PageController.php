<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index() {
        return 'Selamat Datang Page Controller';
    }

    public function about() {
        return 'Nama: Alvanza Saputra <br> NIM: 2341720182 
        <br> Page Controller';
    }

    public function articles($id) {
        return 'Halaman Artikel dengan ID-'. $id 
        .' Page Controller';
    }
}
