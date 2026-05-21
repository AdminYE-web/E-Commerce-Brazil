@extends('admin.layouts.app')

@section('title', 'Contact Detail | Indigo Admin')

@section('css')
<style>
    .contact-detail-card {
        max-width: 1100px;
        margin: 0 auto;
        padding: 24px;
    }

    .section-title {
        margin: 34px 0 16px;
        padding-top: 22px;
        border-top: 1px solid var(--border);
        font-size: 18px;
        font-weight: 700;
        color: var(--fg-dark);
    }

    .btn-outline {
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
        border: 1px solid var(--border);
        background: #fff;
        color: var(--fg);
        font-family: inherit;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .info-table th,
    .info-table td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border);
        text-align: left;
        vertical-align: top;
        font-size: 14px;
    }

    .info-table th {
        width: 220px;
        background: var(--bg);
        color: var(--fg-dark);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        font-size: 12px;
    }

    .info-table td {
        background: #fff;
    }

    .info-table tr:last-child th,
    .info-table tr:last-child td {
        border-bottom: 0;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 10px;
        border-radius: 999px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: 12px;
        font-weight: 600;
        color: var(--fg);
        text-transform: capitalize;
        white-space: nowrap;
    }

    .message-box {
        padding: 18px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: #fff;
        line-height: 1.7;
        white-space: pre-wrap;
    }

    @media (max-width: 900px) {
        .contact-detail-card {
            padding: 18px;
        }

        .info-table th,
        .info-table td {
            display: block;
            width: 100%;
        }
    }
</style>
@endsection

@section('content')

<div class="table-card contact-detail-card">
    <div class="table-header">
        <div>
            <div class="table-title">Contact Detail</div>
            <div class="showing-text">
                {{ $contactSubmission->name }} &middot; {{ $contactSubmission->email }}
            </div>
        </div>

        <a href="{{ route('admin.contact-submissions.index') }}" class="btn-outline">
            Back
        </a>
    </div>

    <div class="section-title">Contact Information</div>

    <table class="info-table">
        <tr>
            <th>ID</th>
            <td>{{ $contactSubmission->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $contactSubmission->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $contactSubmission->email }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ trim(($contactSubmission->country_code ?? '') . ' ' . ($contactSubmission->phone ?? '')) ?: '-' }}</td>
        </tr>
        <tr>
            <th>LINE ID</th>
            <td>{{ $contactSubmission->line_id ?: '-' }}</td>
        </tr>
        <tr>
            <th>Preferred Method</th>
            <td><span class="status-pill">{{ $contactSubmission->contact_method }}</span></td>
        </tr>
        <tr>
            <th>Subject</th>
            <td><span class="status-pill">{{ $contactSubmission->subject }}</span></td>
        </tr>
    </table>

    <div class="section-title">Message</div>

    <div class="message-box">{{ $contactSubmission->message }}</div>

    <div class="section-title">Submission Metadata</div>

    <table class="info-table">
        <tr>
            <th>Attachment</th>
            <td>
                @if($contactSubmission->attachment_path)
                    <a href="{{ asset('storage/' . $contactSubmission->attachment_path) }}" target="_blank" rel="noopener">
                        {{ $contactSubmission->attachment_original_name ?: $contactSubmission->attachment_path }}
                    </a>
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <th>IP Address</th>
            <td>{{ $contactSubmission->ip_address ?: '-' }}</td>
        </tr>
        <tr>
            <th>Submitted At</th>
            <td>{{ $contactSubmission->created_at ? $contactSubmission->created_at->format('d/m/Y H:i') : '-' }}</td>
        </tr>
        <tr>
            <th>Last Updated</th>
            <td>{{ $contactSubmission->updated_at ? $contactSubmission->updated_at->format('d/m/Y H:i') : '-' }}</td>
        </tr>
    </table>
</div>

@endsection
