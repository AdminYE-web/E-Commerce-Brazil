<?php

// app/Http/Controllers/OrderStepController.php
namespace App\Http\Controllers;

class OrderStepController extends Controller
{
    public function index()
    {
        return view('pages.how-to-order');
    }
}
