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
                            <thead class="table-header">
                                <tr>
                                    <th>Bil</th>
                                    <th>Nama Pemohon</th>
                                    <th>Lot/PT</th>
                                    <th>Daerah</th>
                                    <th>Mukim</th>
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
                                        <td>{{ $app->land_lot ?? 'N/A' }}</td>
                                        <td>{{ $app->districts->daerah ?? 'N/A' }}</td>
                                        <td>{{ $app->division->mukim ?? 'N/A' }}</td>
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
                                            @if($app->payment && $app->payment->payment_status === 'completed')
                                                    <a href="javascript:void(0)" 
                                                        class="btn btn-sm print-receipt-third-party"
                                                        data-application-id="{{ $app->id }}"
                                                        style="
                                                            background-color: #f4a100;
                                                            color: #fff;
                                                            border-radius: 20px;
                                                            padding: 6px 16px;
                                                            font-weight: 600;
                                                            white-space: nowrap;
                                                            font-size: 13px;
                                                            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                                                            text-decoration: none;
                                                            border: none;
                                                            display: inline-block;
                                                            transition: background-color 0.3s ease;
                                                        "
                                                        onmouseover="this.style.backgroundColor='#d88f00';"
                                                        onmouseout="this.style.backgroundColor='#f4a100';">
                                                        <strong>Cetak Resit</strong>
                                                    </a>
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
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
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
    document.querySelectorAll('.print-receipt-third-party').forEach(button => {
        button.addEventListener('click', function() {
            const applicationId = this.getAttribute('data-application-id');

            Swal.fire({
                title: 'Cetak Resit',
                html: `
                    <div class="text-center">
                        <p><strong>Nota: Cetakan semula resit dikenakan caj RM 10.00</strong></p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
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
                    }, 5000);
                }
            });
        });
    });
});
</script>
@endsection