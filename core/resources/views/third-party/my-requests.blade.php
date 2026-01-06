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
    
    .table td,
    .table th {
        vertical-align: middle;
        text-align: center;
        font-size: 13px;
    }
    
    .badge {
        font-size: 0.75em;
        padding: 6px 12px;
    }
    
    .status-pending {
        background-color: #ffc107;
        color: #000;
    }
    
    .status-approved {
        background-color: #28a745;
        color: #fff;
    }
    
    .status-rejected {
        background-color: #dc3545;
        color: #fff;
    }
</style>

<title>Permohonan Resit Salinan | JPS</title>

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Header -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fa fa-file-text"></i> Senarai Permohonan Resit Salinan
                    </h3>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Results Count -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <p><strong>{{ $requests->total() }}</strong> Permohonan Dijumpai</p>
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
                                    <th>Tarikh Permohonan</th>
                                    <th>Status</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $index => $request)
                                    <tr>
                                        <td>{{ $requests->firstItem() + $index }}</td>
                                        <td>{{ $request->application->refference_no ?? 'N/A' }}</td>
                                        <td>{{ $request->application->applicant ?? 'N/A' }}</td>
                                        <td>{{ $request->application->land_lot ?? 'N/A' }}
                                            {{ $request->application->landDivision->mukim ?? '' }}, Daerah {{ $request->application->landDistrict->daerah ?? '' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($request->status === 'pending')
                                                <span class="badge status-pending">
                                                    <i class="fa fa-clock"></i> Dalam Proses
                                                </span>
                                            @elseif($request->status === 'approved')
                                                <span class="badge status-approved">
                                                    <i class="fa fa-check-circle"></i> Diluluskan
                                                </span>
                                                <br>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($request->approved_at)->format('d/m/Y H:i') }}
                                                </small>
                                            @else
                                                <span class="badge status-rejected">
                                                    <i class="fa fa-times-circle"></i> Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->status === 'approved')
                                                 @if($request->downloaded_at)
        {{-- Already downloaded --}}
        <button class="btn btn-sm btn-secondary" disabled style="white-space: nowrap;">
            <i class="fa fa-check"></i> Telah Dimuat Turun
        </button>
    @else
        {{-- Not downloaded yet --}}
        <a href="{{ route('third.party.download.receipt', $request->id) }}"
           class="btn btn-sm btn-success"
           style="white-space: nowrap;"
           onclick="disableDownloadButton(this)">
            <i class="fa fa-download"></i> Muat Turun
        </a>
    @endif

                                            @elseif($request->status === 'pending')
                                                <span class="text-muted" style="font-size: 12px;">
                                                    <i class="fa fa-hourglass-half" style="white-space: nowrap;"></i> Menunggu Kelulusan
                                                </span>
                                            @else
                                                <span class="text-danger" style="font-size: 12px;">
                                                    <i class="fa fa-info-circle"></i> 
                                                    @if($request->admin_notes)
                                                        {{ $request->admin_notes }}
                                                    @else
                                                        Permohonan ditolak
                                                    @endif
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            <div class="py-4">
                                                <i class="fa fa-inbox fa-3x mb-3" style="color: #ccc;"></i>
                                                <p>Tiada permohonan resit dijumpai</p>
                                                <a href="{{ route('third.party.dashboard') }}" class="btn btn-primary btn-sm">
                                                    Kembali ke Dashboard
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($requests->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $requests->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function disableDownloadButton(button) {
    button.classList.remove('btn-success');
    button.classList.add('btn-secondary');
    button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Memuat...';
    button.style.pointerEvents = 'none';
}
</script>
@endsection