<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CancelamentoController extends Controller
{
    public function index()
    {
        return view('cancelamento-alteracao');
    }
}
