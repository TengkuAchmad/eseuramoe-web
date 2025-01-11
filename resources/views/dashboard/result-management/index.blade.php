@extends('layout.app')

@push('addon-style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
   .dropdown-toggle::after {
        display: none !important; 
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Result Management</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="d-flex align-items-center mb-3">
                                <a href="{{ route('result.create') }}" class="btn btn-primary mx-1">
                                    <i class="fa fa-plus"></i> Tambah Data
                                </a>
                            </div>
                            <table class="table table-hover" id="crudTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Kabupaten</th>
                                        <th>Desa</th>
                                        <th>Kecamatan</th>
                                        <th>Longitude</th>
                                        <th>Latitude</th>
                                        <th>Umur</th>
                                        <th>Lereng</th>
                                        <th>Drainase</th>
                                        <th>Genangan</th>
                                        <th>Topografi</th>
                                        <th>Bahaya Erosi</th>
                                        <th>Batuan Per</th>
                                        <th>Batuan Sin</th>
                                        <th>Ketinggian</th>
                                        <th>ALB</th>
                                        <th>Rendemen</th>
                                        <th>Densitas</th>
                                        <th>Min TRI</th>
                                        <th>Max TRI</th>
                                        <th>Min GRI</th>
                                        <th>Max GRI</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('addon-script')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
    var table = $('#crudTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ajax: "{{ route('result.index') }}",
        columns: [
            { 
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            { data: 'Title_RI', name: 'Title_RI' },
            { data: 'SocialResultIndex.Kabupaten_SRI', name: 'SocialResultIndex.Kabupaten_SRI' },
            { data: 'SocialResultIndex.Desa_SRI', name: 'SocialResultIndex.Desa_SRI' },
            { data: 'SocialResultIndex.Kecamatan_SRI', name: 'SocialResultIndex.Kecamatan_SRI' },
            { data: 'SocialResultIndex.Longitude_SRI', name: 'SocialResultIndex.Longitude_SRI' },
            { data: 'SocialResultIndex.Latitude_SRI', name: 'SocialResultIndex.Latitude_SRI' },
            { data: 'SoilResultIndex.Umur_SORI', name: 'SoilResultIndex.Umur_SORI' },
            { data: 'SoilResultIndex.Lereng_SORI', name: 'SoilResultIndex.Lereng_SORI' },
            { data: 'SoilResultIndex.Drainase_SORI', name: 'SoilResultIndex.Drainase_SORI' },
            { data: 'SoilResultIndex.Genangan_SORI', name: 'SoilResultIndex.Genangan_SORI' },
            { data: 'SoilResultIndex.Topografi_SORI', name: 'SoilResultIndex.Topografi_SORI' },
            { data: 'SoilResultIndex.BahayaErosi_SORI', name: 'SoilResultIndex.BahayaErosi_SORI' },
            { data: 'SoilResultIndex.BatuanPer_SORI', name: 'SoilResultIndex.BatuanPer_SORI' },
            { data: 'SoilResultIndex.BatuanSin_SORI', name: 'SoilResultIndex.BatuanSin_SORI' },
            { data: 'SoilResultIndex.Ketinggian_SORI', name: 'SoilResultIndex.Ketinggian_SORI' },
            { data: 'PalmResultIndex.ALB_PRI', name: 'PalmResultIndex.ALB_PRI' },
            { data: 'PalmResultIndex.Rendemen_PRI', name: 'PalmResultIndex.Rendemen_PRI' },
            { data: 'PalmResultIndex.Densitas_PRI', name: 'PalmResultIndex.Densitas_PRI' },
            { data: 'TransmittanResultIndex.Min_TRI', name: 'TransmittanResultIndex.Min_TRI' },
            { data: 'TransmittanResultIndex.Max_TRI', name: 'TransmittanResultIndex.Max_TRI' },
            { data: 'GelombangResultIndex.Min_GRI', name: 'GelombangResultIndex.Min_GRI' },
            { data: 'GelombangResultIndex.Max_GRI', name: 'GelombangResultIndex.Max_GRI' },
            { data: 'CreatedAt_RI', name: 'CreatedAt_RI' },
        ]
    });
});
</script>
@endpush
