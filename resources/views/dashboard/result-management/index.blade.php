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
                                <a href="{{ route('result.create') }}" class="btn btn-primary rounded-circle me-2">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <table class="table table-hover" id="crudTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>TITLE</th>
                                        <th>KABUPATEN</th>
                                        <th>KECAMATAN</th>
                                        <th>LONGITUDE</th>
                                        <th>LATITUDE</th>
                                        <th>UMUR</th>
                                        <th>LERENG</th>
                                        <th>DRAINASE</th>
                                        <th>GENANGAN</th>
                                        <th>TOPOGRAFI</th>
                                        <th>BAHAYA EROSI</th>
                                        <th>BATUAN PER</th>
                                        <th>BATUAN SIN</th>
                                        <th>KETINGGIAN</th>
                                        <th>SAMPEL</th>
                                        <th>ALB</th>
                                        <th>RENDEMEN</th>
                                        <th>DENSITAS</th>
                                        <th>MIN TRI</th>
                                        <th>MAX TRI</th>
                                        <th>MIN GRI</th>
                                        <th>MAX GRI</th>
                                        <th>CREATED AT</th>
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
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'Title_RI', name: 'Title_RI', render: data => data || '-' },
            { 
                data: 'SocialResultIndex', 
                name: 'SocialResultIndex.Kabupaten_SRI', 
                render: data => (data && data[0] && data[0].Kabupaten_SRI) || '-' 
            },
            { 
                data: 'SocialResultIndex', 
                name: 'SocialResultIndex.Kecamatan_SRI', 
                render: data => (data && data[0] && data[0].Kecamatan_SRI) || '-' 
            },
            { 
                data: 'SocialResultIndex', 
                name: 'SocialResultIndex.Longitude_SRI', 
                render: data => (data && data[0] && data[0].Longitude_SRI) || '-' 
            },
            { 
                data: 'SocialResultIndex', 
                name: 'SocialResultIndex.Latitude_SRI', 
                render: data => (data && data[0] && data[0].Latitude_SRI) || '-' 
            },
            { 
                data: 'SocialResultIndex', 
                name: 'SocialResultIndex.Umur_SRI', 
                render: data => (data && data[0] && data[0].Umur_SRI) || '-' 
            },
            { data: 'SoilResultIndex.Lereng_SORI', name: 'SoilResultIndex.Lereng_SORI', render: data => data || '-' },
            { data: 'SoilResultIndex.Drainase_SORI', name: 'SoilResultIndex.Drainase_SORI', render: data => data || '-' },
            { data: 'SoilResultIndex.Genangan_SORI', name: 'SoilResultIndex.Genangan_SORI', render: data => data || '-' },
            { data: 'SoilResultIndex.Topografi_SORI', name: 'SoilResultIndex.Topografi_SORI', render: data => data || '-' },
            { data: 'SoilResultIndex.BahayaErosi_SORI', name: 'SoilResultIndex.BahayaErosi_SORI', render: data => data || '-' },
            { data: 'SoilResultIndex.BatuanPer_SORI', name: 'SoilResultIndex.BatuanPer_SORI', render: data => data || '-' },
            { data: 'SoilResultIndex.BatuanSin_SORI', name: 'SoilResultIndex.BatuanSin_SORI', render: data => data || '-' },
            { data: 'SoilResultIndex.Ketinggian_SORI', name: 'SoilResultIndex.Ketinggian_SORI', render: data => data || '-' },
            { data: 'PalmResultIndex.ALB_PRI', name: 'PalmResultIndex.ALB_PRI', render: data => data || '-' },
            { data: 'PalmResultIndex.Rendemen_PRI', name: 'PalmResultIndex.Rendemen_PRI', render: data => data || '-' },
            { data: 'PalmResultIndex.Densitas_PRI', name: 'PalmResultIndex.Densitas_PRI', render: data => data || '-' },
            { data: 'PalmResultIndex.Sampel_PRI', name: 'PalmResultIndex.Sampel_PRI', render: data => data || '-' },
            { data: 'TransmittanResultIndex.Min_TRI', name: 'TransmittanResultIndex.Min_TRI', render: data => data || '-' },
            { data: 'TransmittanResultIndex.Max_TRI', name: 'TransmittanResultIndex.Max_TRI', render: data => data || '-' },
            { data: 'GelombangResultIndex.Min_GRI', name: 'GelombangResultIndex.Min_GRI', render: data => data || '-' },
            { data: 'GelombangResultIndex.Max_GRI', name: 'GelombangResultIndex.Max_GRI', render: data => data || '-' },
            { data: 'CreatedAt_RI', name: 'CreatedAt_RI', render: data => data || '-' }
        ]
    });
});
</script>
@endpush
