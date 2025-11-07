@extends('third-party.layouts.app')

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-home"></i> Dashboard</h5>
    </div>
    
    <section class="content">
        <div class="container-fluid">
            <!-- Welcome Box -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Welcome, {{ $user->name }}!</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge badge-{{ $user->status == 1 ? 'success' : 'danger' }}">
                                    {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                            <p><strong>Member Since:</strong> {{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Your existing dashboard content with charts -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Add your pie chart and other content here -->
                </div>
            </div>
        </div>
    </section>
@endsection