@extends('app')
<style>
.custom-file-input-wrapper {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.custom-file-input-wrapper label {
    margin-bottom: 0;
    cursor: pointer;
}

#file-chosen {
    color: #6c757d;
    font-size: 14px;
}
</style>
@section('content')
<div class="col-md-12 content-header">
    <h6 class="text-uppercase"><i class="fa fa-bullhorn"></i> Tetapan Banner Dashboard</h6>
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
                            <label for="banner_enabled">Status Banner</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="banner_enabled" 
                                       name="banner_enabled" value="1" 
                                       {{ (isset($setting) && $setting->banner_enabled) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="banner_enabled">Aktifkan Banner </label>
                            </div>
                            <small class="form-text text-muted">Dayakan atau lumpuhkan paparan sepanduk pada papan pemuka pengguna</small>
                        </div>
                         <!-- Multiple Banner Images Upload -->
                        <div class="form-group">
                            <label for="banner_images">Imej Banner</label>
                            
                            <!-- Show existing banners -->
                            @if(isset($setting) && $setting->banner_images && is_array($setting->banner_images))
                                <div class="mb-3">
                                    <label class="d-block mb-2"><strong>Banner Semasa:</strong></label>
                                    <div class="row" id="existing-banners">
                                        @foreach($setting->banner_images as $index => $image)
                                            <div class="col-md-3 mb-3 existing-banner-item" data-index="{{ $index }}">
                                                <div class="card">
                                                    <img src="{{ asset('assets/images/uploads/settings/' . $image) }}" 
                                                        class="card-img-top" 
                                                        alt="Banner {{ $index + 1 }}"
                                                        style="height: 150px; object-fit: cover;">
                                                    <div class="card-body p-2 text-center">
                                                        <button type="button" class="btn btn-danger btn-sm remove-existing-banner" 
                                                                data-image="{{ $image }}">
                                                            <i class="fa fa-trash"></i> Padam
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Hidden input to track removed banners -->
                                    <input type="hidden" name="removed_banners" id="removed_banners" value="">
                                </div>
                            @endif
                            
                            <!-- Custom file input wrapper -->
                            <div class="custom-file-input-wrapper">
                                <label for="banner_images" class="btn btn-primary">
                                    <i class="fa fa-upload"></i> Pilih Fail
                                </label>
                                <span id="file-chosen" class="ml-2">Tiada Fail Dipilih</span>
                                <input type="file" 
                                    class="form-control d-none @error('banner_images') is-invalid @enderror" 
                                    id="banner_images" 
                                    name="banner_images[]" 
                                    accept="image/*" 
                                    multiple>
                            </div>
                            
                            @error('banner_images')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                            @error('banner_images.*')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Spesifikasi yang disyorkan : saiz imej: 1200x300 piksel Format fail: JPG, PNG, GIF. Saiz maksimum: 3MB bagi setiap imej. 
                                <strong>Sistem membenarkan pemilihan dan muat naik lebih daripada satu masa</strong>
                            </small>
                            
                            <!-- Preview new uploads -->
                            <div class="row mt-3" id="preview-container"></div>
                        </div>

                        <!-- Banner Title -->
                        <div class="form-group">
                            <label for="banner_title">Tajuk Banner(Pilihan)</label>
                            <input type="text" class="form-control @error('banner_title') is-invalid @enderror" 
                                   id="banner_title" name="banner_title" 
                                   value="{{ old('banner_title', $setting->banner_title ?? '') }}" 
                                   placeholder="Massukkan tajuk banner">
                            @error('banner_title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Banner Link -->
                        <div class="form-group">
                            <label for="banner_link">URL Pautan Banner (Pilihan) </label>
                            <input type="url" class="form-control @error('banner_link') is-invalid @enderror" 
                                   id="banner_link" name="banner_link" 
                                   value="{{ old('banner_link', $setting->banner_link ?? '') }}" 
                                   placeholder="Masukkan alamat URL sasaran">
                            @error('banner_link')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Apablla banner diklik, pengguna akan diarahkan ke URL yang ditetapkan.</small>
                        </div>

                        <!-- Open in New Tab -->
                        <div class="form-group" style="display:none;">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="banner_new_tab" 
                                       name="banner_new_tab" value="1" 
                                       {{ (isset($setting) && $setting->banner_new_tab) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="banner_new_tab">Open link in new tab</label>
                            </div>
                        </div>

                        <!-- Banner Position -->
                        <div class="form-group">
                            <label for="banner_position">Kedudukan Banner</label>
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
                        </div>

                        <!-- Banner Display Duration -->
                         <div class="form-group">
                            <label for="banner_start_date">Tempoh Paparan (Pilihan)</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" class="form-control @error('banner_start_date') is-invalid @enderror" 
                                        id="banner_start_date" name="banner_start_date" 
                                        value="{{ old('banner_start_date', $setting->banner_start_date?->format('Y-m-d') ?? '') }}">
                                    @error('banner_start_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Tarikh Mula</small>
                                </div>
                                <div class="col-md-6">
                                    <input type="date" class="form-control @error('banner_end_date') is-invalid @enderror" 
                                        id="banner_end_date" name="banner_end_date" 
                                        value="{{ old('banner_end_date', $setting->banner_end_date?->format('Y-m-d') ?? '') }}">
                                    @error('banner_end_date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Tarikh Akhir</small>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Kemaskini Tetapan Banner
                            </button>
                            <a href="{{ route('settings.company.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    $(document).ready(function() {
        var removedBanners = [];
        
        // Preview selected images
        $('#banner_images').on('change', function(e) {
            var files = e.target.files;
            var previewContainer = $('#preview-container');
            previewContainer.html('');
            
            if (files.length > 0) {
                $.each(files, function(index, file) {
                    if (file.type.match('image.*')) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var preview = `
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Preview ${index + 1}">
                                        <div class="card-body p-2 text-center">
                                            <small class="text-muted">New Banner ${index + 1}</small>
                                        </div>
                                    </div>
                                </div>
                            `;
                            previewContainer.append(preview);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
        
        // Remove existing banner
        $('.remove-existing-banner').on('click', function() {
            var imageName = $(this).data('image');
            var bannerItem = $(this).closest('.existing-banner-item');
            
            if (confirm('Are you sure you want to remove this banner?')) {
                removedBanners.push(imageName);
                $('#removed_banners').val(JSON.stringify(removedBanners));
                bannerItem.fadeOut(300, function() {
                    $(this).remove();
                });
            }
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('banner_images');
    const fileChosen = document.getElementById('file-chosen');
    
    fileInput.addEventListener('change', function() {
        if (this.files.length === 0) {
            fileChosen.textContent = 'Tiada Fail Dipilih';
        } else if (this.files.length === 1) {
            fileChosen.textContent = this.files[0].name;
        } else {
            fileChosen.textContent = this.files.length + ' fail dipilih';
        }
    });
});
</script>
@endpush
@endsection