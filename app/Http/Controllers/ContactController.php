<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact');
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'contact_method' => ['required', 'in:whatsapp,line,phone'],
            'subject' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'line_id' => ['nullable', 'string', 'max:100'],
            'country_code' => ['nullable', 'string', 'max:10'],
            'phone' => ['nullable', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:5000'],
            'attachment' => ['nullable', 'file', 'max:10240'],
            'g-recaptcha-response' => ['required', 'string'],
        ], [
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
        ]);

        if ($validator->fails()) {
            return $this->validationResponse($request, $validator->errors()->toArray());
        }

        $recaptcha = $this->verifyRecaptcha(
            $request->input('g-recaptcha-response'),
            $request->ip()
        );

        if (! $recaptcha['verified']) {
            return $this->validationResponse($request, [
                'g-recaptcha-response' => [$recaptcha['message']],
            ]);
        }

        // Handle file upload
        $attachmentPath = null;
        $attachmentOriginalName = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentOriginalName = $file->getClientOriginalName();
            $attachmentPath = $file->store('contact-attachments', 'public');
        }

        // Save to database
        $submission = ContactSubmission::create([
            'contact_method' => $request->input('contact_method'),
            'subject' => $request->input('subject'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'line_id' => $request->input('line_id'),
            'country_code' => $request->input('country_code'),
            'phone' => $request->input('phone'),
            'message' => $request->input('message'),
            'attachment_path' => $attachmentPath,
            'attachment_original_name' => $attachmentOriginalName,
            'ip_address' => $request->ip(),
        ]);

        // Send email to sales team
        Mail::to('vendas@example.com')->send(new ContactFormSubmitted($submission));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Sua solicitação de contato foi enviada com sucesso.',
                'redirect' => route('contact.complete'),
            ]);
        }

        return redirect()->route('contact.complete');
    }

    public function complete(): View
    {
        return view('contact-complete');
    }

    private function verifyRecaptcha(string $token, ?string $ip): array
    {
        $secretKey = config('services.recaptcha.secret_key');

        if (! $secretKey) {
            return [
                'verified' => false,
                'message' => 'Unable to verify reCAPTCHA at this time. Please try again later.',
            ];
        }

        try {
            $response = Http::asForm()
                ->timeout(5)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secretKey,
                    'response' => $token,
                    'remoteip' => $ip,
                ]);
        } catch (\Throwable $exception) {
            return [
                'verified' => false,
                'message' => 'Unable to verify reCAPTCHA at this time. Please try again later.',
            ];
        }

        if (! $response->successful()) {
            return [
                'verified' => false,
                'message' => 'Unable to verify reCAPTCHA at this time. Please try again later.',
            ];
        }

        if ($response->json('success') !== true) {
            return [
                'verified' => false,
                'message' => 'reCAPTCHA verification failed. Please try again.',
            ];
        }

        return [
            'verified' => true,
            'message' => null,
        ];
    }

    private function validationResponse(Request $request, array $errors): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 422);
        }

        return back()
            ->withErrors($errors)
            ->withInput();
    }
}
