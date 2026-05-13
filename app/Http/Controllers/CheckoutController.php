<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function authChoice()
    {
        if (auth()->check()) {
            return redirect()->route('checkout.index');
        }

        return view('checkout.auth_choice');
    }

    public function continueGuest()
    {
        session([
            'checkout_as_guest' => true,
        ]);

        return redirect()->route('checkout.index');
    }

    public function index()
    {
        if (!auth()->check() && !session('checkout_as_guest')) {
            return redirect()->route('checkout.authChoice');
        }

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', compact('cart'));
    }
}