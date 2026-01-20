@extends('app')

@section('content')
<div class="col-md-12 content-header">
    <h6 class="text-uppercase"><i class="fa fa-bullhorn"></i> Dashboard Banner Settings</h6>
</div>

<section class="content">
    <div class="row">
        
        <div class="col-md-12">
            <div class="card border-top-primary">
                <div class="card-body">
                    <form action="{{ route('settings.banner.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Banner Status -->
                        <div class="form-group">
                            <label for="banner_enabled">Banner Status</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="banner_enabled" 
                                       name="banner_enabled" value="1" 
                                       {{ (isset($setting) && $setting->banner_enabled) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="banner_enabled">Enable Dashboard Banner</label>
                            </div>
                            <small class="form-text text-muted">Enable or disable the banner display on user dashboard</small>
                        </div>

                        <!-- Banner Image Upload -->
                        <div class="form-group">
                            <label for="banner_image">Banner Image</label>
                            @if(isset($setting) && $setting->banner_image)
                                <div class="mb-2">
                                    <img src="{{ asset('assets/images/uploads/settings/' . $setting->banner_image) }}" alt="Current Banner" 
                                         style="max-width: 100%; max-height: 200px; border: 1px solid #ddd; border-radius: 4px;">
                                    <p class="text-muted small">Current Banner</p>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('banner_image') is-invalid @enderror" 
                                   id="banner_image" name="banner_image" accept="image/*">
                            @error('banner_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Recommended size: 1200x300px. Formats: JPG, PNG, GIF (Max: 3MB)</small>
                        </div>

                        <!-- Banner Title -->
                        <div class="form-group">
                            <label for="banner_title">Banner Title (Optional)</label>
                            <input type="text" class="form-control @error('banner_title') is-invalid @enderror" 
                                   id="banner_title" name="banner_title" 
                                   value="{{ old('banner_title', $setting->banner_title ?? '') }}" 
                                   placeholder="Enter banner title">
                            @error('banner_title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">This will be used as the alt text and tooltip</small>
                        </div>

                        <!-- Banner Link -->
                        <div class="form-group">
                            <label for="banner_link">Banner Link URL (Optional)</label>
                            <input type="url" class="form-control @error('banner_link') is-invalid @enderror" 
                                   id="banner_link" name="banner_link" 
                                   value="{{ old('banner_link', $setting->banner_link ?? '') }}" 
                                   placeholder="https://example.com/promotion">
                            @error('banner_link')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">When clicked, the banner will redirect to this URL</small>
                        </div>

                        <!-- Open in New Tab -->
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="banner_new_tab" 
                                       name="banner_new_tab" value="1" 
                                       {{ (isset($setting) && $setting->banner_new_tab) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="banner_new_tab">Open link in new tab</label>
                            </div>
                        </div>

                        <!-- Banner Position -->
                        <div class="form-group">
                            <label for="banner_position">Banner Position</label>
                            <select class="form-control @error('banner_position') is-invalid @enderror" 
                                    id="banner_position" name="banner_position">
                                <option value="top" {{ (isset($setting) && $setting->banner_position == 'top') ? 'selected' : '' }}>
                                    Top of Dashboard
                                </option>
                                <option value="middle" {{ (isset($setting) && $setting->banner_position == 'middle') ? 'selected' : '' }}>
                                    Middle of Dashboard
                                </option>
                                <option value="bottom" {{ (isset($setting) && $setting->banner_position == 'bottom') ? 'selected' : '' }}>
                                    Bottom of Dashboard
                                </option>
                            </select>
                            @error('banner_position')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Choose where to display the banner on user dashboard</small>
                        </div>

                        <!-- Banner Display Duration -->
                        <div class="form-group">
                            <label for="banner_start_date">Display Period (Optional)</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" class="form-control @error('banner_start_date') is-invalid @enderror" 
                                           id="banner_start_date" name="banner_start_date" 
                                           value="{{ old('banner_start_date', $setting->banner_start_date ?? '') }}">
                                    @error('banner_start_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Start Date</small>
                                </div>
                                <div class="col-md-6">
                                    <input type="date" class="form-control @error('banner_end_date') is-invalid @enderror" 
                                           id="banner_end_date" name="banner_end_date" 
                                           value="{{ old('banner_end_date', $setting->banner_end_date ?? '') }}">
                                    @error('banner_end_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">End Date</small>
                                </div>
                            </div>
                            <small class="form-text text-muted">Leave blank to display indefinitely</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Banner Settings
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