<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
