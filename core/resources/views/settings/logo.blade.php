@extends('app')

@section('content')
<div class="col-md-12 content-header">
    <h6 class="text-uppercase"><i class="fa fa-image"></i> Logo & Images Settings</h6>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-3">
            @include('settings.partials._menu')
        </div>
        
        <div class="col-md-9">
            <div class="card border-top-primary">
                <div class="card-body">
                    <form action="{{ route('settings.logo.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Logo Upload -->
                        <div class="form-group">
                            <label for="logo">Company Logo</label>
                            @if(isset($setting) && $setting->logo)
                                <div class="mb-2">
                                    <img src="{{ image_url($setting->logo) }}" alt="Current Logo" style="max-width: 200px; max-height: 100px;">
                                    <p class="text-muted small">Current Logo</p>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                   id="logo" name="logo" accept="image/*">
                            @error('logo')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Recommended size: 245px width. Formats: JPG, PNG, GIF (Max: 2MB)</small>
                        </div>

                        <!-- Favicon Upload -->
                        <div class="form-group">
                            <label for="favicon">Favicon</label>
                            @if(isset($setting) && $setting->favicon)
                                <div class="mb-2">
                                    <img src="{{ image_url($setting->favicon) }}" alt="Current Favicon" style="max-width: 32px; max-height: 32px;">
                                    <p class="text-muted small">Current Favicon</p>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('favicon') is-invalid @enderror" 
                                   id="favicon" name="favicon" accept="image/*">
                            @error('favicon')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Recommended size: 16x16px. Formats: ICO, PNG (Max: 1MB)</small>
                        </div>

                        <!-- Login Background Upload -->
                        <div class="form-group">
                            <label for="login_bg">Login Background Image</label>
                            @if(isset($setting) && $setting->login_bg)
                                <div class="mb-2">
                                    <img src="{{ image_url($setting->login_bg) }}" alt="Current Background" style="max-width: 300px; max-height: 150px;">
                                    <p class="text-muted small">Current Background</p>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('login_bg') is-invalid @enderror" 
                                   id="login_bg" name="login_bg" accept="image/*">
                            @error('login_bg')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Recommended size: 1920x1080px. Formats: JPG, PNG, GIF (Max: 5MB)</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Images
                            </button>
                            <a href="{{ route('settings.company.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection