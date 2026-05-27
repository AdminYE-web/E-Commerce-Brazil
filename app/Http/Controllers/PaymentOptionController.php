<?php

namespace App\Http\Controllers;

class PaymentOptionController extends Controller
{
    public function index()
    {
        return view('payment-options');
    }
}
