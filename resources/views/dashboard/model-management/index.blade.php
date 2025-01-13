@extends('layout.app')

@push('addon-style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .dropdown-toggle::after {
        display: none;
    }
    .btn-default.btnDelete:hover {
        background-color: #DC143C !important;
        color: #fff !important;
    }
    #Type_MD {
        width: 100%;
        padding: 10px 15px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
        transition: border-color 0.3s, box-shadow 0.3s ease-in-out;
    }

    #Type_MD:hover {
        border-color: #f05c26;
        box-shadow: 0 0 5px rgba(240, 92, 38, 0.6);
    }

    #Type_MD:focus {
        border-color: #f05c26;
        box-shadow: 0 0 8px rgba(240, 92, 38, 0.6);
        outline: none;
    }

    #Type_MD option {
        padding: 10px;
    }

    #Type_MD option:hover {
        background-color: #f05c26 !important;
        color: white !important;
        transition: background-color 0.3s ease !important;
    }

    .badge-custom {
        font-size: 0.7rem;
        font-weight: 500;
        padding: 0.4em 0.8em;
        border-radius: 0.25rem;
        text-transform: capitalize;
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Model Management</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="d-flex align-items-center mb-3">
                                <button type="button" class="btn btn-primary rounded-circle me-2" data-bs-toggle="modal" data-bs-target="#createModal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <table class="table table-hover" id="crudTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NAME</th>
                                        <th>URL</th>
                                        <th>TYPE</th>
                                        <th>ACTION</th>
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Model Management</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createForm" action="{{ route('model.create') }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <span class="text-danger">*</span><label class="form-label">Model Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Model name..." required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <span class="text-danger">*</span><label class="form-label">Upload Model File</label>
                                <input type="file" name="files" id="files" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <span class="text-danger">*</span><label class="form-label">Type</label>
                                <select name="type" id="Type_MD" class="form-control" required>
                                    <option value="" disabled selected>--Pilih--</option>
                                    <option value="SCAN_TEST">SCAN_TEST</option>
                                    <option value="LAB_TEST">LAB_TEST</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"><span class="me-2"><i class="fa fa-times"></i></span>Close</button>
                    <button type="submit" class="btn btn-primary"><span class="me-2"><i class="fa fa-save"></i></span>Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
            ajax: {
                url: "{{ route('model.index') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                error: function(xhr, error, thrown) {
                    console.log('Ajax error:', error);
                }
            },
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                { 
                    data: 'Name_MD', 
                    name: 'Name_MD',
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                { 
                    data: 'Url_MD', 
                    name: 'Url_MD',
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                {
                    data: 'Type_MD',
                    name: 'Type_MD',
                    render: function(data) {
                        let badgeClass = (data === 'SCAN_TEST') ? 'badge-primary' : 'badge-dark';
                        return `<span class="badge ${badgeClass} badge-custom">${data}</span>`;
                    }
                },
                { 
                    data: 'action', 
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    $('body').on('click', '.btnDelete', function() {
        const uuid = $(this).data('id');
        
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
                    url: `{{ route('model.delete', '') }}/${uuid}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#crudTable').DataTable().ajax.reload();
                            Swal.fire('Deleted!', 'Model has been deleted.', 'success');
                        } else {
                            Swal.fire('Warning!', response.message || 'Model is currently being used and cannot be deleted.', 'warning');
                        }
                    },
                    error: function(xhr, status, error) {
                        const errorMessage = xhr.responseJSON?.message || 'Model is currently being used and cannot be deleted.';
                        Swal.fire('Warning!', errorMessage, 'warning');
                    }
                });
            }
        });
    });
</script>
@endpush
