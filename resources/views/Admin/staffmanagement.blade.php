@extends('Admin.layout')

@section('content')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:24px;}
.btn-cyan{background:linear-gradient(135deg,#696cff,#03c3ec)!important;color:#fff!important;border:none!important;font-weight:500;padding:9px 18px;border-radius:8px;font-size:0.875rem;transition:all .2s;display:inline-flex;align-items:center;gap:6px;cursor:pointer;text-decoration:none;}
.btn-cyan:hover{box-shadow:0 6px 20px rgba(105,108,255,0.38)!important;transform:translateY(-1px);color:#fff!important;}
.custom-card{background:var(--bs-card-bg,#fff);border-radius:12px;border:1px solid rgba(231,231,255,0.8);box-shadow:0 2px 20px rgba(105,108,255,0.08);padding:24px;}
.table-custom thead th{font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;border-bottom:2px solid #e7e7ff!important;padding:12px 14px;}
.table-custom tbody td{font-size:0.875rem;padding:13px 14px;border-bottom:1px solid rgba(231,231,255,0.5)!important;vertical-align:middle;}
</style>

<div class="page-header">
    <div>
        <h4 class="fw-bold mb-0">Staff Management</h4>
        <small class="text-muted">Manage staff members, roles and access</small>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('createrole') }}" class="btn-cyan"><i class="fa-solid fa-shield-halved"></i> Manage Roles</a>
        <a href="{{ route('createstaff') }}" class="btn-cyan"><i class="fa-solid fa-user-plus"></i> Add Staff</a>
    </div>
</div>

<div class="custom-card">
    <div class="table-responsive">
        <table class="table table-custom table-borderless align-middle w-100" id="staff-table">
            <thead>
                <tr>
                    <th class="text-center" style="width:50px;">#</th>
                    <th>Date</th>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" style="width:100px;">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

{{-- Scripts pushed to bottom of body — after jQuery & DataTables are loaded --}}
@push('scripts')
<script>
$(document).ready(function () {
    $('#staff-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("staffmanagement") }}',
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'created_at',  name: 'created_at' },
            { data: 'staff_id',    name: 'staff_id' },
            { data: 'staff_name',  name: 'staff_name' },
            { data: 'mobile',      name: 'mobile' },
            { data: 'email',       name: 'email' },
            { data: 'role_name',   name: 'role_name', className: 'fw-semibold' },
            { data: 'status',      name: 'status',    className: 'text-center', orderable: false },
            { data: 'action',      name: 'action',    orderable: false, searchable: false, className: 'text-center' }
        ],
        language: { search: '_INPUT_', searchPlaceholder: 'Search staff...', lengthMenu: '_MENU_' },
        order: [[1, 'desc']]
    });
});

function deleteStaff(id) {
    Swal.fire({
        title: 'Delete Staff?', text: 'This cannot be undone.', icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#ff3e1d', cancelButtonColor: '#566a7f',
        confirmButtonText: 'Yes, Delete'
    }).then(function(r) {
        if (r.isConfirmed) {
            $.ajax({
                url: '/Admin/deletestaff/' + id, type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function() {
                    Swal.fire({ icon: 'success', title: 'Deleted!', confirmButtonColor: '#696cff' });
                    $('#staff-table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire({ icon: 'error', title: 'Error!', text: xhr.responseText });
                }
            });
        }
    });
}
</script>
@endpush
