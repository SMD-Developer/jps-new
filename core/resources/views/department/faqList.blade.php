@php
use Illuminate\Support\Str;
@endphp
@extends('app')
<style>
    /* Make buttons take full width on small screens */
    @media (max-width: 768px) {
        .d-grid {
            display: block;
            width: 100%;
        }

        .btn-group {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
    }
    table.table {
        font-size:13px;
    }
     thead{
    border-color: inherit;
    border-style: none !important;
    border-width: 0;
}
</style>
<title>{{ $title }} | JPS</title>
@section('content')
<div class="col-md-12 content-header">
    <h5><i class="fa fa-list"></i> {{ $title }}</h5>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <!-- Add FAQ Button -->
                    <div class="row mb-3">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                                <i class="fa fa-plus"></i> <strong>Tambah Soalan</strong>
                            </button>
                        </div>
                    </div>

                    <!-- Search and Per Page will go here -->
                    <div class="d-flex align-items-baseline justify-content-between mb-3 mx-3">
                        <!-- Left side: Records Per Page -->
                        <div class="d-flex align-items-baseline">
                            <label for="perPageSelect" class="me-2">Tunjuk :&nbsp; </label>
                            <select id="perPageSelect" class="form-select form-select-sm" onchange="changePerPage()" style="width: auto">
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        
                        <!-- Right side: Search Box -->
                        <div class="d-flex align-items-baseline">
                            <label for="searchInput" class="me-2">Carian :&nbsp; </label>
                            <input type="text" 
                                id="searchInput" 
                                class="form-control form-control-sm" 
                                placeholder="" 
                                value="{{ request('search') }}"
                                style="width: 300px">
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><strong>Bil</strong></th>
                                    <th><strong>Soalan</strong></th>
                                    <th><strong>Jawapan</strong></th>
                                    <th><strong>Status</strong></th>
                                    <th><strong>Untuk Tindakan</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $index => $faq)
                                    <tr>
                                        <td>{{ ($faqs->currentPage() - 1) * $faqs->perPage() + $index + 1 }}</td>
                                        <td>{{ $faq->question }}</td>
                                        <td>{{ Str::limit($faq->answer, 100) }}</td>
                                        
                                        <td>
                                            @if($faq->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" onclick="editFaq({{ $faq->id }}, '{{ addslashes($faq->question) }}', '{{ addslashes($faq->answer) }}', {{ $faq->status }})"
                                                    class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span class="me-2">
                                    Page <strong>{{ $faqs->currentPage() }}</strong> of
                                    <strong>{{ $faqs->lastPage() }}</strong>
                                </span>
                            </div>

                            <nav>
                                <ul class="pagination">
                                    @if ($faqs->currentPage() > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $faqs->url(1) }}&per_page={{ $perPage }}&search={{ request('search') }}">« First</a>
                                        </li>
                                    @endif

                                    @if ($faqs->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">‹ Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $faqs->previousPageUrl() }}&per_page={{ $perPage }}&search={{ request('search') }}">‹ Previous</a>
                                        </li>
                                    @endif

                                    @foreach ($faqs->links()->elements as $element)
                                        @if (is_string($element))
                                            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                        @endif
                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                <li class="page-item {{ $page == $faqs->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $url }}&per_page={{ $perPage }}&search={{ request('search') }}">{{ $page }}</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endforeach

                                    @if ($faqs->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $faqs->nextPageUrl() }}&per_page={{ $perPage }}&search={{ request('search') }}">Next ›</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Next ›</span>
                                        </li>
                                    @endif

                                    @if ($faqs->currentPage() < $faqs->lastPage())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $faqs->url($faqs->lastPage()) }}&per_page={{ $perPage }}&search={{ request('search') }}">Last »</a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add FAQ Modal -->
<div class="modal fade" id="addFaqModal" tabindex="-1" role="dialog" aria-labelledby="addFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFaqModalLabel">
                    <i class="fa fa-plus"></i> Tambah FAQ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addFaqForm" method="POST" action="{{ route('faq.store') }}">
                @csrf
                <div class="modal-body">
                    <div id="formAlert" class="alert" style="display: none;"></div>
                    
                    <div class="form-group row mb-3">
                        <label for="question" class="col-sm-3 col-form-label">
                            Solan<span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="question" name="question" rows="2" required></textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="answer" class="col-sm-3 col-form-label">
                            Jawapan <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="answer" name="answer" rows="4" required></textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="status" class="col-sm-3 col-form-label">
                            Status <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit FAQ Modal -->
<div class="modal fade" id="editFaqModal" tabindex="-1" role="dialog" aria-labelledby="editFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFaqModalLabel">
                    <i class="fa fa-edit"></i> Kemaskini FAQ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFaqForm" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div id="editFormAlert" class="alert" style="display: none;"></div>
                    
                    <div class="form-group row mb-3">
                        <label for="edit_question" class="col-sm-3 col-form-label">
                            Soalan <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="edit_question" name="question" rows="2" required></textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="edit_answer" class="col-sm-3 col-form-label">
                            Jawapan <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="edit_answer" name="answer" rows="4" required></textarea>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="edit_status" class="col-sm-3 col-form-label">
                            Status <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-save"></i> Kemaskini
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Include SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function changePerPage() {
        let perPage = document.getElementById('perPageSelect').value;
        let search = document.getElementById('searchInput').value;
        let url = new URL(window.location.href);
        url.searchParams.set('page', 1);
        url.searchParams.set('per_page', perPage);
        if(search) {
            url.searchParams.set('search', search);
        }
        window.location.href = url.toString();
    }

    function searchFaqs() {
        let searchValue = document.getElementById('searchInput').value;
        let perPage = document.getElementById('perPageSelect').value;
        let url = new URL(window.location.href);
        url.searchParams.set('page', 1);
        url.searchParams.set('per_page', perPage);
        
        if(searchValue) {
            url.searchParams.set('search', searchValue);
        } else {
            url.searchParams.delete('search');
        }
        
        window.location.href = url.toString();
    }

    function editFaq(id, question, answer, status) {
        $('#edit_question').val(question);
        $('#edit_answer').val(answer);
        $('#edit_status').val(status);
        $('#editFaqForm').attr('action', '/faq/' + id);
        $('#editFaqModal').modal('show');
    }

    $(document).ready(function() {
        // Search with delay
        $('#searchInput').on('keyup', function(e) {
            clearTimeout(window.searchTimeout);
            window.searchTimeout = setTimeout(function() {
                searchFaqs();
            }, 500);
        });

        // Add FAQ Form
        $('#addFaqForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        $('#addFaqModal').modal('hide');
                        location.reload();
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if(errors) {
                        let errorMsg = Object.values(errors).flat().join('<br>');
                        $('#formAlert').removeClass('alert-success').addClass('alert-danger')
                            .html(errorMsg).show();
                    }
                }
            });
        });

        // Edit FAQ Form
        $('#editFaqForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        $('#editFaqModal').modal('hide');
                        location.reload();
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if(errors) {
                        let errorMsg = Object.values(errors).flat().join('<br>');
                        $('#editFormAlert').removeClass('alert-success').addClass('alert-danger')
                            .html(errorMsg).show();
                    }
                }
            });
        });

        // Delete FAQ
        $(document).on('click', '.deleteFaqBtn', function() {
            let faqId = $(this).data('id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/faq/' + faqId,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if(response.success) {
                                Swal.fire('Deleted!', 'FAQ has been deleted.', 'success');
                                location.reload();
                            }
                        }
                    });
                }
            });
        });

        // Clear modals on close
        $('#addFaqModal').on('hidden.bs.modal', function () {
            $('#addFaqForm')[0].reset();
            $('#formAlert').hide();
        });

        $('#editFaqModal').on('hidden.bs.modal', function () {
            $('#editFaqForm')[0].reset();
            $('#editFormAlert').hide();
        });
    });
</script>
@endsection