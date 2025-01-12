@extends('layout.app')

@push('addon-style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 5px
    }
    .select2-container .select2-selection--single {
        padding-top: 4px;
    }
    .textarea {
        height: 150px !important;
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>New Result Management</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('result.index') }}">Result Management</a></div>
            <div class="breadcrumb-item">Create New</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                 <form action="{{ route('result.store') }}" method="POST" class="needs-validation" novalidate="">
                        @csrf
                        <div class="card-body">
                            <h4 class="text-primary mt-4">Soil Information</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 col-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Title</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Title_RI" placeholder="Your title name..." required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-2 col-lg-2 col-sm-2">
                                    <div class="form-group">
                                        <label>Umur</label><span class="text-danger">*</span>
                                        <input type="number" class="form-control" name="Umur_SORI" required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-2 col-lg-2 col-sm-2">
                                    <div class="form-group">
                                        <label>Lereng</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Lereng_SORI" required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-2 col-lg-2 col-sm-2">
                                    <div class="form-group">
                                        <label>Drainase</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Drainase_SORI" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Genangan</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Genangan_SORI" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Ketinggian</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Ketinggian_SORI" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Topografi</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Topografi_SORI" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Bahaya Erosi</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="BahayaErosi_SORI" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-4 col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Batuan Per</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="BatuanPer_SORI" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-4 col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Batuan Sin</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="BatuanSin_SORI" required>
                                    </div>
                                </div>
                            </div>

                            <h4 class="text-primary mt-4">Palm Information</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 col-4 col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>ALB</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="ALB_PRI" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-4 col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Rendemen</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Rendemen_PRI" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-4 col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Densitas</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Densitas_PRI" required>
                                    </div>
                                </div>
                            </div>

                            <h4 class="text-primary mt-4">Result Information</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-3 col-3 col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Min TRI</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Min_TRI" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Max TRI</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Max_TRI" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Min GRI</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Min_GRI" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 col-lg-3 col-sm-3">
                                    <div class="form-group">
                                        <label>Max GRI</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Max_GRI" required>
                                    </div>
                                </div>
                            </div>

                            <h4 class="text-primary">Location Information</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 col-4 col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Desa</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Desa_SRI" placeholder="Enter desa..." required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-4 col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Kecamatan</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Kecamatan_SRI" placeholder="Enter kecamatan..." required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-4 col-lg-4 col-sm-4">
                                    <div class="form-group">
                                        <label>Kabupaten</label><span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="Kabupaten_SRI" placeholder="Enter kabupaten..." required>
                                    </div>
                                </div>
                                <div class="col-md-5 col-5 col-lg-5 col-sm-5">
                                    <div class="form-group">
                                        <label>Longitude</label><span class="text-danger">*</span>
                                        <input type="number" class="form-control" name="Longitude_SRI" placeholder="Longitude" required>
                                        <small class="fst-italic">Based on Google Maps</small>
                                    </div>
                                </div>
                                <div class="col-md-5 col-5 col-lg-5 col-sm-5">
                                    <div class="form-group">
                                        <label>Latitude</label><span class="text-danger">*</span>
                                        <input type="number" class="form-control" name="Latitude_SRI" placeholder="Latitude" required>
                                        <small class="fst-italic">Based on Google Maps</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-3 col-lg-3 col-sm-3"></div>
                                <div class="col-md-3 col-3 col-lg-3 col-sm-3"></div>
                                <div class="col-md-3 col-3 col-lg-3 col-sm-3">
                                    <div class="d-grid">
                                        <a href="{{ route('result.index') }}" class="btn btn-dark"><span class="me-2"><i class="fa fa-arrow-left"></i></span>Back</a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 col-lg-3 col-sm-3">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary"><span class="me-2"><i class="fa fa-save"></i></span>Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('addon-script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
