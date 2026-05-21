@extends('admin.layouts.app')

@section('title', 'Quotations | Indigo Admin')
@section('css')
    <style>
        .quotation-status-select {
            min-width: 120px;
            height: 34px;
            border-radius: 999px;
            border: 1px solid #d1d5db;
            padding: 0 12px;
            font-size: 13px;
            font-weight: 700;
            outline: none;
            cursor: pointer;
        }

        .quotation-status-select.active {
            background: #ecfdf5;
            color: #047857;
            border-color: #a7f3d0;
        }

        .quotation-status-select.not_active {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        .quotation-status-select.is-saving {
            opacity: 0.6;
            pointer-events: none;
        }
        .quotation-action-buttons {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: nowrap;   /* บังคับให้อยู่แถวเดียว */
    white-space: nowrap;
}

.quotation-action-btn {
    min-width: 64px;
    height: 32px;
    border-radius: 8px;
    padding: 0 12px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: .2s ease;
    flex-shrink: 0;      /* ไม่ให้ปุ่มหดจนตกบรรทัด */
}

.quotation-action-btn.view {
    background: #eef4ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
}

.quotation-action-btn.edit {
    background: #fff7ed;
    color: #c2410c;
    border: 1px solid #fed7aa;
}

.quotation-action-btn.pdf {
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
}

.quotation-action-btn:hover {
    transform: translateY(-1px);
    opacity: .9;
}
    </style>
@endsection
@section('content')

    <div class="table-card">
        <div class="table-header">
            <div>
                <div class="table-title">Quotations</div>
                <div class="showing-text">Manage customer quotations.</div>
            </div>

            <a href="{{ route('admin.quotations.create') }}" class="btn-primary">
                + Create Quotation
            </a>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Quotation No.</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th width="220">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($quotations as $quotation)
                    <tr>
                        <td>{{ $quotation->quotation_no }}</td>
                        <td>{{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d/m/Y') }}</td>
                        <td>{{ $quotation->customer_name }}</td>
                        <td>{{ $quotation->customer_email ?? '-' }}</td>
                        <td>¥{{ number_format($quotation->grand_total, 2) }}</td>
                        <td>
                            <select class="quotation-status-select {{ $quotation->status }}"
                                data-update-url="{{ route('admin.quotations.updateStatus', $quotation->quotation_id) }}">
                                <option value="active" {{ $quotation->status === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="not_active" {{ $quotation->status === 'not_active' ? 'selected' : '' }}>
                                    Not Active
                                </option>
                            </select>
                        </td>
                        <td>
    <div class="quotation-action-buttons">
        <a href="{{ route('admin.quotations.show', $quotation->quotation_id) }}"
           class="quotation-action-btn view">
            View
        </a>

        <a href="{{ route('admin.quotations.edit', $quotation->quotation_id) }}"
           class="quotation-action-btn edit">
            Edit
        </a>

        <a href="{{ route('admin.quotations.pdf', $quotation->quotation_id) }}"
           class="quotation-action-btn pdf">
            PDF
        </a>
    </div>
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:32px;">
                            No quotations found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $quotations->links() }}
    </div>

@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.quotation-status-select').forEach(function(select) {
                select.addEventListener('change', function() {
                    const updateUrl = this.dataset.updateUrl;
                    const status = this.value;
                    const selectEl = this;

                    selectEl.classList.add('is-saving');

                    fetch(updateUrl, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                status: status,
                            }),
                        })
                        .then(function(response) {
                            if (!response.ok) {
                                throw new Error('Unable to update status.');
                            }

                            return response.json();
                        })
                        .then(function() {
                            selectEl.classList.remove('active', 'not_active');

                            if (status === 'active') {
                                selectEl.classList.add('active');
                            } else {
                                selectEl.classList.add('not_active');
                            }
                        })
                        .catch(function(error) {
                            console.error(error);
                            alert('Unable to update quotation status.');
                        })
                        .finally(function() {
                            selectEl.classList.remove('is-saving');
                        });
                });
            });
        });
    </script>
@endsection
