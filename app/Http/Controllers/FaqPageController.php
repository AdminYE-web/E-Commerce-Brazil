<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqPageController extends Controller
{
    public function index(Request $request)
    {
        $langKey = $this->getLangKey();

        $faqs = Faq::query()
            ->where('language', $langKey)
            ->where('status', 'show')
            ->where('show_main', 1)
            ->orderBy('sort_order')
            ->orderBy('faq_id', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('faqs.index', compact('faqs', 'langKey'));
    }
}
