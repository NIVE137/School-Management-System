@extends('Admin.layout')

@section('content')
<style>
.page-back{display:flex;align-items:center;gap:14px;margin-bottom:22px;}
.btn-back{background:#fff;border:1.5px solid #e7e7ff;border-radius:8px;width:38px;height:38px;display:flex;align-items:center;justify-content:center;color:#566a7f;text-decoration:none;transition:all .2s;flex-shrink:0;}
.btn-back:hover{background:#696cff;border-color:#696cff;color:#fff;}
.custom-card{background:var(--bs-card-bg,#fff);border-radius:12px;border:1px solid rgba(231,231,255,0.8);box-shadow:0 2px 20px rgba(105,108,255,0.08);padding:24px;margin-bottom:24px;}
.form-label-custom{font-size:0.79rem;font-weight:600;color:#566a7f;margin-bottom:6px;display:block;}
.input-custom{border-radius:8px!important;border:1.5px solid #d9dee3!important;padding:10px 14px!important;font-size:0.88rem!important;}
.input-custom:focus{border-color:#696cff!important;box-shadow:0 0 0 3px rgba(105,108,255,0.12)!important;}
.btn-cyan{background:linear-gradient(135deg,#696cff,#03c3ec);color:#fff;border:none;font-weight:600;padding:10px 22px;border-radius:8px;font-size:0.875rem;transition:all .2s;cursor:pointer;white-space:nowrap;}
.btn-cyan:hover{box-shadow:0 6px 20px rgba(105,108,255,0.38);transform:translateY(-1px);color:#fff;}
.table-custom thead th{font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;border-bottom:2px solid #e7e7ff!important;padding:12px 14px;}
.table-custom tbody td{font-size:0.875rem;padding:13px 14px;border-bottom:1px solid rgba(231,231,255,0.5)!important;}
</style>

<div class="page-back">
    <a href="{{ route('staffmanagement') }}" class="btn-back"><i class="fa-solid fa-angle-left"></i></a>
    <div>
        <h4 class="fw-bold mb-0">Manage Roles</h4>
        <small class="text-muted">Create and manage staff roles</small>
    </div>
</div>

<div class="custom-card">
    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#a5b7c8;margin-bottom:16px;padding-bottom:8px;border-bottom:2px solid #e7e7ff;">Add New Role</div>
    <form action="{{ route('storerole') }}" method="POST">
        @csrf
        <div class="row g-3 align-items-end">
            <div class="col-md-10">
                <label class="form-label-custom">Role Name</label>
                <input type="text" name="role_name" class="form-control input-custom" placeholder="e.g. Class Teacher, Lab Instructor" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-cyan w-100"><i class="fas fa-plus me-1"></i> Add</button>
            </div>
        </div>
    </form>
</div>

<div class="custom-card">
    <div class="table-responsive">
        <table class="table table-custom table-borderless align-middle w-100" id="role-table">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Date Added</th>
                    <th class="text-center">Role Name</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#role-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: { url: '{{ route("createrole") }}', type: 'GET' },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'date',        name: 'created_at',  className: 'text-center' },
            { data: 'role_name',   name: 'role_name',   className: 'text-center fw-semibold' },
            { data: 'action',      name: 'action',      orderable: false, searchable: false, className: 'text-center' }
        ],
        language: { search: '_INPUT_', searchPlaceholder: 'Search...', lengthMenu: '_MENU_' }
    });
});

function deleteRole(id) {
    Swal.fire({
        title: 'Delete Role?', text: 'This will remove the role permanently.', icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#ff3e1d', cancelButtonColor: '#566a7f',
        confirmButtonText: 'Yes, Delete'
    }).then(function(r) {
        if (r.isConfirmed) {
            $.ajax({
                url: '/Admin/deleterole/' + id, type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function() {
                    Swal.fire({ icon: 'success', title: 'Deleted!', confirmButtonColor: '#696cff' });
                    $('#role-table').DataTable().ajax.reload();
                }
            });
        }
    });
}
</script>
@endpush
