<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function hello() {
        return 'Hello World Controller';
    }

    public function greeting(){
        return view('blog.hello')
            ->with('name', 'Alvanza')
            ->with('age', 20);
    }
}
