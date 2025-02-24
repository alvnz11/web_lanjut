<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function food()
    {
        return view('category.food-beverage', [
            'title' => 'Food & Beverage'
        ]);
    }

    public function beauty()
    {
        return view('category.beauty-health', [
            'title' => 'Beauty & Health'
        ]);
    }

    public function home()
    {
        return view('category.home-care', [
            'title' => 'Home Care'
        ]);
    }

    public function baby()
    {
        return view('category.baby-kid', [
            'title' => 'Baby & Kid'
        ]);
    }
}
