@extends('admin.layouts.app')

@section('title', 'Reply Contact Submission | Indigo Admin')

@section('css')
    <style>
        .reply-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
        }

        .reply-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 24px;
        }

        .reply-title {
            margin: 0 0 6px;
            font-size: 24px;
            color: var(--fg-dark);
        }

        .reply-subtitle {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .submission-box {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 22px;
            font-size: 14px;
            line-height: 1.6;
        }

        .submission-box strong {
            color: var(--fg-dark);
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--fg-dark);
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            background: #fff;
            color: var(--fg);
            font-size: 14px;
            font-family: inherit;
        }

        .form-group textarea {
            min-height: 180px;
            resize: vertical;
        }

        .error-text {
            margin-top: 6px;
            color: #b91c1c;
            font-size: 13px;
        }

        .reply-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
        }

        .btn-outline,
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            font-family: inherit;
            border: 1px solid transparent;
        }

        .btn-outline {
            background: #fff;
            border-color: var(--border);
            color: var(--fg);
        }

        .btn-primary {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }
    </style>
@endsection

@section('content')

    <div class="reply-card">
        <div class="reply-header">
            <div>
                <h1 class="reply-title">Reply Contact Submission</h1>
                <p class="reply-subtitle">
                    Write a response, attach a file, and keep reply log.
                </p>
            </div>

            <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="btn-outline">
                Back
            </a>
        </div>

        <div class="submission-box">
            <div><strong>Name:</strong> {{ $submission->name }}</div>
            <div><strong>Email:</strong> {{ $submission->email }}</div>
            <div><strong>Phone:</strong>
                {{ trim(($submission->country_code ?? '') . ' ' . ($submission->phone ?? '')) ?: '-' }}</div>
            <div><strong>Subject:</strong> {{ $submission->subject ?? '-' }}</div>
            <div><strong>Message:</strong><br>{{ $submission->message ?? '-' }}</div>
        </div>

        <form action="{{ route('admin.contact-submissions.send-reply', $submission) }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Reply Subject</label>
                <input type="text" name="reply_subject"
                    value="{{ old('reply_subject', 'Reply to your contact submission') }}">
                @error('reply_subject')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Reply Message <span style="color:#dc2626;">*</span></label>
                <textarea name="reply_message" required>{{ old('reply_message') }}</textarea>
                @error('reply_message')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Attachment</label>
                <input type="file" name="attachment">
                @error('attachment')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="reply-actions">
                <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn-primary">
                    Save Reply
                </button>
            </div>
        </form>
    </div>

@endsection