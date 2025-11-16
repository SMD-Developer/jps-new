@extends('third-party.layouts.app')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    .table-header {
        background: #f0f0f0;
        font-weight: bold;
        text-align: center;
        font-size: 13px;
    }
    
    .table td, .table th {
        vertical-align: middle;
        text-align: center;
        font-size: 13px;
    }
    
    .badge {
        font-size: 0.75em;
        padding: 6px 12px;
    }
    
    .filter-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
</style>

<title>Sejarah Pembayaran | JPS</title>

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Header -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fa fa-credit-card"></i> Sejarah Pembayaran Saya
                    </h3>
                </div>

                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="filter-section">
                        <form method="GET" action="{{ route('third.party.my.payments') }}" id="filterForm">
                            <div class="row g-3">
                                <!-- Search -->
                                <div class="col-md-4">
                                    <label class="form-label">Carian</label>
                                    <input type="text" name="q" class="form-control" 
                                        placeholder="No Rujukan, Lot/PT, Nama..." 
                                        value="{{ request('q') }}">
                                </div>

                                <!-- Method Filter -->
                                <div class="col-md-2">
                                    <label class="form-label">Kaedah</label>
                                    <select name="method_filter" class="form-select">
                                        <option value="all" {{ request('method_filter') == 'all' ? 'selected' : '' }}>Semua</option>
                                        <option value="B2B" {{ request('method_filter') == 'B2B' ? 'selected' : '' }}>FPX B2B</option>
                                        <option value="B2C" {{ request('method_filter') == 'B2C' ? 'selected' : '' }}>FPX B2C</option>
                                    </select>
                                </div>

                                <!-- Date From -->
                                <div class="col-md-2">
                                    <label class="form-label">Dari Tarikh</label>
                                    <input type="date" name="date_from" class="form-control" 
                                        value="{{ request('date_from') }}">
                                </div>

                                <!-- Date To -->
                                <div class="col-md-2">
                                    <label class="form-label">Hingga Tarikh</label>
                                    <input type="date" name="date_to" class="form-control" 
                                        value="{{ request('date_to') }}">
                                </div>

                                <!-- Buttons -->
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fa fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>

                            <!-- Reset Button -->
                            @if(request()->hasAny(['q', 'method_filter', 'date_from', 'date_to']))
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <a href="{{ route('third.party.my.payments') }}" class="btn btn-secondary btn-sm">
                                            <i class="fa fa-refresh"></i> Reset Filter
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>

                    <!-- Results Count -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <p><strong>{{ $payments->total() }}</strong> Pembayaran Dijumpai</p>
                        </div>
                    </div>
                    
                    <!-- Results Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-header">
                                <tr>
                                    <th>Bil</th>
                                    <th>No Rujukan</th>
                                    <th>Nama Pemohon</th>
                                    <th>Lot/PT</th>
                                    <th>Daerah</th>
                                    <th>Mukim</th>
                                    <th>Amaun (RM)</th>
                                    <th>Kaedah</th>
                                    <th>Tarikh</th>
                                    <th>Tindakan</th> {{-- Add this --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $index => $payment)
                                    <tr>
                                        <td>{{ $payments->firstItem() + $index }}</td>
                                        <td>{{ $payment->application->refference_no ?? 'N/A' }}</td>
                                        <td>{{ $payment->application->applicant ?? 'N/A' }}</td>
                                        <td>{{ $payment->application->land_lot ?? 'N/A' }}</td>
                                        <td>{{ $payment->application->landDistrict->daerah ?? 'N/A' }}</td>
                                        <td>{{ $payment->application->landDivision->mukim ?? 'N/A' }}</td>
                                        <td class="text-end">{{ number_format($payment->amount, 2) }}</td>
                                        <td>
                                            @if($payment->method == 'FPX_B2B')
                                                <span class="badge bg-primary">FPX B2B</span>
                                            @elseif($payment->method == 'FPX_B2C')
                                                <span class="badge bg-info">FPX B2C</span>
                                            @else
                                                {{ $payment->method }}
                                            @endif
                                        </td>
                                        <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') : 'N/A' }}</td>
                                        <td>
                                            {{-- Add View Receipt Button --}}
                                            <a href="{{ route('third.party.view.receipt', ['application_id' => $payment->application_id, 'payment_uuid' => $payment->uuid]) }}" 
                                                class="btn btn-sm btn-primary"
                                                style="border-radius: 15px; padding: 4px 12px; font-weight: 600; font-size: 12px; white-space: nowrap;">
                                                    <i class="fa fa-eye"></i> Lihat Resit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">
                                            <div class="py-4">
                                                <i class="fa fa-inbox fa-3x mb-3" style="color: #ccc;"></i>
                                                <p>Tiada sejarah pembayaran dijumpai</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($payments->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $payments->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection