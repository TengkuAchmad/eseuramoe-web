@extends('layout.app')

@push('addon-style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .dropdown-toggle::after {
        display: none;
    }
    .btn-default:hover {
        background-color:#f05c26 !important;
        color: #fff !important;
    }
    .btn-default.btnDelete:hover {
        background-color: #DC143C !important;
        color: #fff !important;
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Users Management</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="d-flex align-items-center mb-3">
                                <button type="button" class="btn btn-primary rounded-circle me-2" data-bs-toggle="modal" data-bs-target="#createModalAdmin">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-danger mx-1" id="btnDeleteAll" 
                                    @if(empty($cekAdmin) || $cekAdmin === null)
                                        style="display: none;"
                                    @endif>
                                    <i class="fa fa-trash"></i> Delete All
                                </button>
                            </div>
                            <table class="table table-hover" id="crudTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Last Login</th>
                                        <th>Action</th>
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
<div class="modal fade" id="createModalAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createFormAdmin" action="{{ route('admin.create') }}" method="POST" class="needs-validation" novalidate="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <span class="text-danger">*</span><label class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Your name..." required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <span class="text-danger">*</span><label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="@gmail" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <span class="text-danger">*</span><label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"><span class="me-2"><i class="fa fa-times"></i></span>Close</button>
                    <button type="submit" class="btn btn-success"><span class="me-2"><i class="fa fa-save"></i></span>Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New users</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" action="{{ route('users.update', ['uuid' => ':uuid']) }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <span class="text-danger">*</span><label class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Upload Profile Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"><span class="me-2"><i class="fa fa-times"></i></span>Close</button>
                    <button type="submit" class="btn btn-success"><span class="me-2"><i class="fa fa-save"></i></span>Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Password Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updatePasswordForm" action="{{ route('admin.update-password', ['uuid' => ':uuid']) }}" method="POST" class="needs-validation" novalidate="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Current Password</label>
                                <input type="text" class="form-control" value="********" disabled>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <span class="text-danger">*</span><label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" required>
                                <small class="text-muted">Min 6 characters</small>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <span class="text-danger">*</span><label class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                                <small class="text-muted">Min 6 characters</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                        <span class="me-2"><i class="fa fa-times"></i></span>Close
                    </button>
                    <button type="submit" class="btn btn-success">
                        <span class="me-2"><i class="fa fa-key"></i></span>Update Password
                    </button>
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
                url: "{{ route('admin.index') }}",
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
                    data: 'PhotoUrl_UD', 
                    name: 'PhotoUrl_UD',
                    orderable: false 
                },
                { data: 'Name_UD', name: 'Name_UD' },
                { data: 'Email_UD', name: 'Email_UD' },
                { data: 'UpdatedAt_UD', name: 'UpdatedAt_UD' },
                { data: 'LoggedAt_UD', name: 'LoggedAt_UD' },
                { 
                    data: 'action', 
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    $(document).on('click', '#btn_edit', function() {
        var uuid = $(this).data('uuid');
        var name = $(this).data('name');

        $('#editForm #name').val(name);
        $('#editForm').attr('action', '{{ route("admin.update", ":uuid") }}'.replace(':uuid', uuid));
    });

    $(document).on('click', '#btn_update_password', function() {
        var uuid = $(this).data('uuid');
        $('#updatePasswordForm').attr('action', '{{ route("admin.update-password", ":uuid") }}'.replace(':uuid', uuid));
    });


    $(document).on('click', '.btnDelete', function() {
        var uuid = $(this).data('uuid');

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
                    url: '{{ route("admin.delete", ":uuid") }}'.replace(':uuid', uuid),
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        Swal.fire('Deleted!', 'The user has been deleted.', 'success');
                        location.reload();
                    },
                    error: function(response) {
                        Swal.fire('Error!', 'Failed to delete the user.', 'error');
                    }
                });
            }
        });
    });

    $(document).on('click', '#btnDeleteAll', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete all users permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete all!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.delete.all") }}',
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        Swal.fire('Deleted!', 'All users have been deleted.', 'success');
                        location.reload();
                    },
                    error: function(response) {
                        Swal.fire('Error!', 'Failed to delete all users.', 'error');
                    }
                });
            }
        });
    });

</script>
@endpush
