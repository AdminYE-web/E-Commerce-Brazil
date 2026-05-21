<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactSubmission::query()
            ->orderByDesc('created_at')
            ->orderByDesc('id');

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('contact_method')) {
            $query->where('contact_method', $request->string('contact_method')->toString());
        }

        if ($request->filled('subject')) {
            $query->where('subject', $request->string('subject')->toString());
        }

        $submissions = $query->paginate(20)->withQueryString();

        return view('admin.contact_submissions.index', compact('submissions'));
    }

    public function show(ContactSubmission $contactSubmission)
    {
        return view('admin.contact_submissions.show', compact('contactSubmission'));
    }
}
