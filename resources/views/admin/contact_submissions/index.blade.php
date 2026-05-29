@extends('admin.layouts.app')

@section('title', 'Contact Submissions | Indigo Admin')

@section('css')
    <style>
        .filter-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 16px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .filter-form input,
        .filter-form select {
            height: 38px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            font-family: inherit;
            font-size: 14px;
        }

        .filter-form input {
            min-width: 280px;
            flex: 1;
        }

        .contact-name-text {
            font-weight: 700;
            color: var(--fg-dark);
        }

        .contact-sub {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 12px;
        }

        .status-badge {
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

        .message-preview {
            max-width: 360px;
            color: var(--fg);
            line-height: 1.45;
        }

        .date-text {
            white-space: nowrap;
            color: var(--fg);
            font-size: 13px;
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

        @media (max-width: 900px) {
            .table-card {
                overflow-x: auto;
            }

            table {
                min-width: 1100px;
            }

            .filter-form {
                flex-direction: column;
            }

            .filter-form input,
            .filter-form select,
            .filter-form .btn-primary,
            .filter-form .btn-outline {
                width: 100%;
            }
        }

        .manage-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            flex-wrap: wrap;
        }

        .reply-done {
            background: #ecfdf5;
            border-color: #a7f3d0;
            color: #047857;
        }

        .reply-pending {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #c2410c;
        }
    </style>
@endsection

@section('content')

    <div class="table-card">
        <div class="table-header">
            <div>
                <div class="table-title">Contact Submissions</div>
                <div class="showing-text">
                    View messages submitted from the public contact form.
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.contact-submissions.index') }}" class="filter-form">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search name, email, phone, subject or message">

            <select name="contact_method">
                <option value="">All Contact Methods</option>
                @foreach(['whatsapp', 'line', 'phone'] as $method)
                    <option value="{{ $method }}" {{ request('contact_method') === $method ? 'selected' : '' }}>
                        {{ ucfirst($method) }}
                    </option>
                @endforeach
            </select>

            <select name="subject">
                <option value="">All Subjects</option>
                @foreach(['payment', 'quote', 'support', 'order'] as $subject)
                    <option value="{{ $subject }}" {{ request('subject') === $subject ? 'selected' : '' }}>
                        {{ ucfirst($subject) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn-primary">
                Search
            </button>

            <a href="{{ route('admin.contact-submissions.index') }}" class="btn-outline">
                Reset
            </a>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Contact</th>
                    <th>Method</th>
                    <th>Subject</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Reply Status</th>
                    <th>Date</th>
                    <th style="text-align:right;">Manage</th>
                </tr>
            </thead>

            <tbody>
                @forelse($submissions as $submission)
                    <tr>
                        <td>
                            <div class="contact-name-text">{{ $submission->name }}</div>
                            <span class="contact-sub">{{ $submission->email }}</span>
                        </td>

                        <td>
                            <span class="status-badge">{{ $submission->contact_method }}</span>
                        </td>

                        <td>
                            <span class="status-badge">{{ $submission->subject }}</span>
                        </td>

                        <td>{{ trim(($submission->country_code ?? '') . ' ' . ($submission->phone ?? '')) ?: '-' }}</td>

                        <td>
                            <div class="message-preview">
                                {{ \Illuminate\Support\Str::limit($submission->message, 90) }}
                            </div>
                        </td>
                        <td>
                            @if (($submission->status_reply ?? 'pending') === 'reply')
                                <span class="status-badge reply-done">Reply</span>
                            @else
                                <span class="status-badge reply-pending">Pending</span>
                            @endif
                        </td>

                        <td>
                            <span class="date-text">
                                {{ $submission->created_at ? $submission->created_at->format('d/m/Y H:i') : '-' }}
                            </span>
                        </td>

                        <td style="text-align:right;">
                            <div class="manage-actions">
                                <a href="{{ route('admin.contact-submissions.show', $submission) }}" class="btn-outline">
                                    Detail
                                </a>

                                <a href="{{ route('admin.contact-submissions.reply', $submission) }}" class="btn-primary">
                                    Reply
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:32px;">
                            No contact submissions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-container">
            {{ $submissions->links() }}
        </div>
    </div>

@endsection