@extends('third-party.layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .table-header {
        background: #f0f0f0;
        font-weight: bold;
        text-align: center;
    }
    
    .table td,
    .table th {
        vertical-align: middle;
        text-align: center;
    }

    .table tbody {
        font-size: 13px;
    }
    
    .back-btn {
        margin-bottom: 20px;
    }
    
    .badge {
        font-size: 0.75em;
    }
    
    .search-summary .badge {
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .custom-swal-popup {
        font-size: 14px;
    }

    .swal2-popup .swal2-title {
        font-size: 20px;
        color: #333;
    }

    .swal2-popup .swal2-content {
        font-size: 14px;
    }
</style>

<title>{{ $title }} | JPS</title>

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Header -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Senarai Carian</h3>
                </div>

                <div class="card-body">
                    <!-- Search Summary -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-info search-summary">
                                <strong>Kriteria Carian:</strong>
                                @if(!empty($filters['district']))
                                    <span class="badge bg-primary">Daerah: {{ $districts[$filters['district']]->daerah ?? $filters['district'] }}</span>
                                @endif
                                @if(!empty($filters['division']))
                                    <span class="badge bg-secondary">Mukim: {{ $divisions[$filters['division']]->mukim ?? $filters['division'] }}</span>
                                @endif
                                @if(!empty($filters['applicant_name']))
                                    <span class="badge bg-success">Pemohon: {{ $filters['applicant_name'] }}</span>
                                @endif
                                @if(!empty($filters['lot_number']))
                                    <span class="badge bg-warning">Lot/PT: {{ $filters['lot_number'] }}</span>
                                @endif
                                @if(!empty($filters['reference_number']))
                                    <span class="badge bg-info">No Rujukan: {{ $filters['reference_number'] }}</span>
                                @endif
                                @if(!empty($filters['application_date']))
                                    <span class="badge bg-dark">Tarikh: {{ \Carbon\Carbon::parse($filters['application_date'])->format('d/m/Y') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Results Count -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <p><strong>{{ $applications->total() }}</strong> Permohonan Dijumpai</p>
                        </div>
                    </div>
                    
                    <!-- Results Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-header" style="font-size: 13px;">
                                <tr>
                                    <th>Bil</th>
                                    <th>Nama Pemohon</th>
                                    <th>Lot/PT</th>
                                    <!-- <th>Daerah</th>
                                    <th>Mukim</th> -->
                                    <th>Tarikh Permohonan</th>
                                    <th>No Rujukan</th>
                                    <th>Status</th>
                                    <th>Untuk Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $index => $app)
                                    <tr>
                                        <td>{{ $applications->firstItem() + $index }}</td>
                                        <td>{{ $app->applicant ?? 'N/A' }}</td>
                                        <td>{{ $app->land_lot ?? 'N/A' }}, {{ $app->land_area }}, {{ $app->landDivision->mukim ?? '' }},
                                            Daerah {{ $app->landDistrict->daerah ?? '' }}
                                        </td>
                                        <!-- <td>{{ $app->districts->daerah ?? 'N/A' }}</td>
                                        <td>{{ $app->division->mukim ?? 'N/A' }}</td> -->
                                        <td>{{ \Carbon\Carbon::parse($app->created_at)->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="#">
                                                {{ $app->refference_no }}
                                            </a>
                                        </td>
                                        <td>
                                            @switch($app->status)
                                                @case('approved')
                                                    <span class="badge bg-success">Diluluskan</span>
                                                    @break
                                                @case('rejected')
                                                    <span class="badge bg-danger">Tolak</span>
                                                    @break
                                                @case('pending')
                                                    <span class="badge bg-warning">Belum selesai</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">N/A</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @php
                                                $isLegacy = \Carbon\Carbon::parse($app->created_at)->lt('2025-11-16');
                                                $hasOriginalPayment = $app->payment && $app->payment->payment_status === 'completed';
                                                
                                                // Check if third party has paid for reprint
                                                $thirdPartyPayment = null;
                                                $receiptRequest = null;
                                                
                                                if (auth('third_party')->check()) {
                                                    $thirdPartyPayment = \App\Models\Payment::where('application_id', $app->id)
                                                        ->where('third_party_id', auth('third_party')->id())
                                                        ->where('payment_type', 'third_party')
                                                        ->where('payment_status', 'completed')
                                                        ->first();
                                                        
                                                    if ($thirdPartyPayment) {
                                                        $receiptRequest = \App\Models\ReceiptRequest::where('application_id', $app->id)
                                                            ->where('third_party_id', auth('third_party')->id())
                                                            ->first();
                                                    }
                                                }
                                            @endphp

                                            @if($hasOriginalPayment)
                                                @if($isLegacy)
                                                    {{-- LEGACY APPLICATION (Before 16 Nov 2025) --}}
                                                    <a href="javascript:void(0)" 
                                                        class="btn btn-sm pay-for-legacy-receipt"
                                                        data-application-id="{{ $app->id }}"
                                                        style="
                                                            background-color: #f4a100;
                                                            color: #fff;
                                                            border-radius: 20px;
                                                            padding: 6px 16px;
                                                            font-weight: 600;
                                                            white-space:nowrap;
                                                            font-size: 13px;
                                                            border: none;">
                                                        <i class="fa fa-credit-card"></i> Mohon Resit
                                                    </a>
                                                @else
                                                    {{-- NEW APPLICATION (After 16 Nov 2024) - Automated Flow --}}
                                                    <a href="javascript:void(0)" 
                                                        class="btn btn-sm print-receipt-third-party"
                                                        data-application-id="{{ $app->id }}"
                                                        style="
                                                            background-color: #f4a100;
                                                            color: #fff;
                                                            border-radius: 20px;
                                                            padding: 6px 16px;
                                                            font-weight: 600;
                                                            font-size: 13px;
                                                            white-space: nowrap;
                                                            border: none;">
                                                        <i class="fa fa-credit-card"></i> Cetak Resit
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">Tiada permohonan dijumpai</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 d-flex justify-content-between align-items-center">

                        <!-- NOTE -->
                        <p class="text-muted mb-0" style="font-size: 14px; font-weight: 500;">
                            <strong>Nota:</strong> Cetakan <strong>SALINAN</strong> resit akan dikenakan <strong>RM 10.00</strong>.
                        </p>

                        <!-- BACK BUTTON -->
                        <a href="{{ url()->previous() }}" 
                        class="btn btn-secondary" 
                        style="border-radius: 20px; padding: 8px 20px; font-size: 14px; font-weight: 600;">
                            Kembali
                        </a>

                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-2">
                        {{ $applications->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Carian Permohonan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('search-filter') }}" method="POST" id="searchModalForm">
                    @csrf
                    <!-- District Dropdown -->
                    <div class="form-group mb-3">
                        <label>Daerah</label>
                        <select class="form-control" name="district" id="modal_district">
                            <option value="">{{ __('app.select_district') }}</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->iddaerah ?? '' }}"
                                    {{ old('district', $request->district ?? '') == ($district->iddaerah ?? '') ? 'selected' : '' }}>
                                    {{ $district->daerah ?? 'Unknown District' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Division Dropdown -->
                    <div class="form-group mb-3">
                        <label>Mukim</label>
                        <select class="form-control" name="division" id="modal_division">
                            <option value="">{{ __('app.select_division') }}</option>
                        </select>
                    </div>

                    <!-- Applicant Field -->
                    <div class="form-group mb-3">
                        <label>Nama Pemohon</label>
                        <input type="text" class="form-control" name="applicant_search" id="modal_applicant_search" 
                               placeholder="Cari nama pemohon..." value="{{ old('applicant_search') }}">
                        <input type="hidden" name="applicant_id" id="modal_applicant_id">
                    </div>

                    <!-- Lot/PT Field -->
                    <div class="form-group mb-3">
                        <label>Lot/PT</label>
                        <input type="text" class="form-control" name="lot_pt_grant" id="modal_lot_pt_grant"
                               placeholder="Masukkan Lot/PT..." value="{{ old('lot_pt_grant') }}">
                    </div>

                    <!-- Reference Number Field -->
                    <div class="form-group mb-3">
                        <label>No Rujukan</label>
                        <input type="text" class="form-control" name="reference_number" id="modal_reference_number"
                               placeholder="Masukkan no rujukan..." value="{{ old('reference_number') }}">
                    </div>

                    <!-- Application Date Field -->
                    <div class="form-group mb-3">
                        <label>Tarikh Permohonan</label>
                        <input type="date" class="form-control" name="application_date" id="modal_application_date"
                               value="{{ old('application_date') }}">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ===== FOR LEGACY APPLICATIONS - Payment Button =====
    document.querySelectorAll('.pay-for-legacy-receipt').forEach(button => {
        button.addEventListener('click', function() {
            const applicationId = this.getAttribute('data-application-id');

            Swal.fire({
                title: 'Bayaran Diperlukan',
                html: `
                    <div class="text-center">
                        <p><strong>Bayaran: RM 10.00</strong></p>
                        <p>Selepas pembayaran berjaya, permohonan anda untuk salinan resit akan diproses oleh bahagian kewangan dalam tempoh 7-14 hari bekerja.</p>
                    </div>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#f4a100',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Teruskan ke Pembayaran',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Mengalihkan...',
                        text: 'Sedang mengalihkan ke halaman pembayaran',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                        window.location.href = '{{ route("third.party.payment.selection", "__ID__") }}'
                            .replace('__ID__', applicationId);
                    }, 2000);
                }
            });
        });
    });

    // ===== FOR LEGACY APPLICATIONS - Submit Request Button (After Payment) =====
    document.querySelectorAll('.submit-request-btn').forEach(button => {
        button.addEventListener('click', function() {
            const applicationId = this.getAttribute('data-application-id');

            Swal.fire({
                title: 'Hantar Permohonan Resit',
                html: `
                    <div class="text-center">
                        <p>Permohonan anda akan dihantar kepada pihak pentadbir untuk kelulusan.</p>
                        <p><strong>Tempoh pemprosesan: 1-3 hari bekerja</strong></p>
                        <p class="text-muted" style="font-size: 12px;">
                            Anda akan dimaklumkan melalui email apabila resit sudah sedia.
                        </p>
                    </div>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hantar Permohonan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit request via AJAX
                    fetch('{{ route("third.party.submit.request") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            application_id: applicationId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berjaya!',
                                text: 'Permohonan anda telah dihantar. Anda akan dimaklumkan melalui email.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Ralat!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Ralat!', 'Sila cuba lagi.', 'error');
                    });
                }
            });
        });
    });

    // ===== FOR NEW APPLICATIONS - Existing Payment Button (Keep as is) =====
    document.querySelectorAll('.print-receipt-third-party').forEach(button => {
        button.addEventListener('click', function() {
            const applicationId = this.getAttribute('data-application-id');

            Swal.fire({
                title: 'Cetak Resit',
                html: `
                    <div class="text-center">
                        <p><strong>Bayaran: RM 10.00</strong></p>
                        <p>Selepas pembayaran berjaya, salinan resit boleh dicetak serta-merta.</p>
                    </div>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Teruskan ke Pembayaran',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Mengalihkan...',
                        text: 'Sedang mengalihkan ke halaman pembayaran',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                        window.location.href = '{{ route("third.party.payment.selection", "__ID__") }}'
                            .replace('__ID__', applicationId);
                    }, 2000);
                }
            });
        });
    });
});
</script>
@endsection