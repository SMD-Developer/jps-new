<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Header -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Senarai Carian</h3>
                    <div class="card-tools">
                        <!-- Back to Login Button -->
                        <a href="{{ route('client_login') }}" class="btn btn-secondary btn-sm me-2">
                            <i class="fa fa-arrow-left"></i> Kembali ke Log Masuk
                        </a>
                
                        <!-- Search Button -->
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="fa fa-search"></i> Carian
                        </button>
                    </div>
                </div>

                
                <div class="card-body">
                    <!-- Search Summary -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <strong>Kriteria Carian:</strong>
                                @if(!empty($filters['state']))
                                    <span class="badge bg-primary">Negeri: {{ $states->find($filters['state'])->negeri ?? $filters['state'] }}</span>
                                @endif
                                @if(!empty($filters['district']))
                                    <span class="badge bg-secondary">Daerah: {{ $districts->find($filters['district'])->daerah ?? $filters['district'] }}</span>
                                @endif
                                @if(!empty($filters['division']))
                                    <span class="badge bg-success">Mukim: {{ $divisions->find($filters['division'])->mukim ?? $filters['division'] }}</span>
                                @endif
                                @if(!empty($filters['applicant_name']))
                                    <span class="badge bg-warning">Name: {{ $filters['applicant_name'] }}</span>
                                @endif
                                @if(!empty($filters['lot_number']))
                                    <span class="badge bg-danger">Lot: {{ $filters['lot_number'] }}</span>
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
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pemohon</th>
                                    <th>Lot</th>
                                    <th>Negeri</th>
                                    <th>Daerah</th>
                                    <th>Mukim</th>
                                    <th>Tarikh Permohonan</th>
                                    <th>No Rujukan</th>
                                    <th>Status</th>
                                    <!--<th>Actions</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $index => $app)
                                    <tr>
                                        <td>{{ $applications->firstItem() + $index }}</td>
                                        <td>{{ $app->applicant }}</td>
                                        <td>{{ $app->land_lot }}</td>
                                        <td>{{ $app->state_name }}</td>
                                        <td>{{ $app->district_name }}</td>
                                        <td>{{ $app->division_name }}</td>
                                        <td>{{ $app->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $app->refference_no }}</td>
                                        <td>
                                            @if($app->status === 'approved')
                                                <span class="badge bg-success">Diluluskan</span>
                                            @elseif($app->status === 'pending')
                                                <span class="badge bg-warning">Belum selesai</span>
                                            @elseif($app->status === 'rejected')
                                                <span class="badge bg-danger">Tolak</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($app->status) }}</span>
                                            @endif

                                            <a href="javascript:void(0);"
                                                class="btn btn-sm btn-primary print-receipt-third-party"
                                                data-application-id="{{ $app->id }}"
                                                style="white-space: nowrap;">
                                                <i class="fas fa-print"></i>
                                                <strong>Cetak Resit</strong>
                                            </a>

                                        </td>
                                        <td>
                                            <!-- Add action buttons here if needed -->
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">No applications found</td>
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
                <h5 class="modal-title">Search Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- TODO: Add your search form here -->
                <form method="GET" action="{{ route('applications.search') }}">
                    <div class="mb-3">
                        <label for="applicant_name" class="form-label">Applicant Name</label>
                        <input type="text" name="applicant_name" id="applicant_name" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Third Party Info Modal -->
<div class="modal fade" id="thirdPartyInfoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Borang Pendaftaran Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="thirdPartyForm">
                <div class="modal-body">
                    <input type="hidden" id="modal_application_id" name="application_id">
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Caj Dikenakan: <strong>RM 10.00</strong>
                    </div>
                    
                    <div class="mb-3">
                        <label for="third_party_name" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="third_party_name" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="third_party_id" class="form-label">No. Kad Pengenalan/No. Daftar Perniagaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="third_party_id" name="id_number" required>
                        <small class="form-text text-muted">
                            Kad Pengenalan Baru perlu letak (-)
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="third_party_address" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="third_party_address" name="address" rows="3" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="third_party_email" class="form-label">Emel <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="third_party_email" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Hantar dan Membuat Pembayaran</button> 
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const thirdPartyModal = new bootstrap.Modal(document.getElementById('thirdPartyInfoModal'));
        
        // Handle both print and reprint clicks for third party (same behavior for both)
        document.querySelectorAll('.print-receipt-third-party, .reprint-receipt-third-party').forEach(button => {
            button.addEventListener('click', function() {
                const applicationId = this.getAttribute('data-application-id');
                
                Swal.fire({
                    title: 'Cetak Resit',
                    text: 'Nota: Cetakan semula resit dikenakan caj RM 10.00',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show modal to collect third party info
                        document.getElementById('modal_application_id').value = applicationId;
                        document.getElementById('thirdPartyForm').reset();
                        thirdPartyModal.show();
                    }
                });
            });
        });

        // Handle form submission
        document.getElementById('thirdPartyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const applicationId = document.getElementById('modal_application_id').value;
            
            // Show loading
            Swal.fire({
                title: 'Processing...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit third party info - CORRECTED ROUTE
            fetch('{{ route("third.party.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    application_id: applicationId,
                    name: formData.get('name'),
                    id_number: formData.get('id_number'),
                    address: formData.get('address'),
                    email: formData.get('email')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    thirdPartyModal.hide();
                    
                    // CORRECTED ROUTE - Use the proper third party payment selection route
                    window.location.href = '{{ route("third.party.payment.selection", "__ID__") }}'.replace('__ID__', applicationId);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to save information'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request'
                });
            });
        });
    });
</script>
</body>
</html>
