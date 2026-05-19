<?php

namespace App\Http\Controllers;

use App\Models\EmailSubscript;
use Illuminate\Http\Request;

class NewsletterSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        EmailSubscript::updateOrCreate(
            ['email' => strtolower($validated['email'])],
            ['is_subscript' => 1]
        );

        return back()->with('newsletter_success', __('messages.newsletter.success'));
    }
}
