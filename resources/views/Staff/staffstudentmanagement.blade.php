@extends('Staff.stafflayout')

@section('content')
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:24px;}
.btn-cyan{background:linear-gradient(135deg,#696cff,#03c3ec)!important;color:#fff!important;border:none!important;font-weight:500;padding:9px 18px;border-radius:8px;font-size:0.875rem;transition:all .2s;display:inline-flex;align-items:center;gap:6px;cursor:pointer;}
.btn-cyan:hover{box-shadow:0 6px 20px rgba(105,108,255,0.38)!important;transform:translateY(-1px);color:#fff!important;}
.custom-card{background:var(--bs-card-bg,#fff);border-radius:12px;border:1px solid rgba(231,231,255,0.8);box-shadow:0 2px 20px rgba(105,108,255,0.08);padding:24px;}
.table-custom thead th{font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;border-bottom:2px solid #e7e7ff!important;padding:12px 14px;white-space:nowrap;}
.table-custom tbody td{font-size:0.875rem;padding:12px 14px;border-bottom:1px solid rgba(231,231,255,0.5)!important;vertical-align:middle;}
</style>

<div class="page-header">
    <div>
        <h4 class="fw-bold mb-0">Student Management</h4>
        <small class="text-muted">View and manage your students</small>
    </div>
    <button class="btn-cyan" onclick="location.href='{{ route('staffcreatestudent') }}'">
        <i class="fa-solid fa-user-plus"></i> Create Student
    </button>
</div>

<div class="custom-card">
    <div class="table-responsive">
        <table class="table table-custom table-borderless align-middle w-100" id="staff-student-table">
            <thead>
                <tr>
                    <th class="text-center" style="width:50px;">#</th>
                    <th>Date</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Parent Name</th>
                    <th>Parent Mobile</th>
                    <th class="text-center">Class</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Documents</th>
                    <th class="text-center" style="width:100px;">Action</th>
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
    $('#staff-student-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("staffstudentmanagement") }}',
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex',   name: 'DT_RowIndex',   orderable: false, searchable: false, className: 'text-center' },
            { data: 'date',          name: 'created_at' },
            { data: 'student_id',    name: 'student_id',    className: 'text-center' },
            { data: 'name',          name: 'student_name',  className: 'fw-semibold' },
            { data: 'email',         name: 'email' },
            { data: 'parent_name',   name: 'parent_name' },
            { data: 'parent_mobile', name: 'parent_mobile' },
            { data: 'class',         name: 'class_name',    className: 'text-center fw-semibold' },
            { data: 'status',        name: 'status',        className: 'text-center', orderable: false },
            { data: 'documents',     name: 'documents',     orderable: false, searchable: false, className: 'text-center' },
            { data: 'action',        name: 'action',        orderable: false, searchable: false, className: 'text-center' }
        ],
        language: { search: '_INPUT_', searchPlaceholder: 'Search students...', lengthMenu: '_MENU_' },
        order: [[1, 'desc']]
    });
});

function deleteStudent(id) {
    Swal.fire({
        title: 'Delete Student?', text: 'This cannot be undone.', icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#ff3e1d', cancelButtonColor: '#566a7f',
        confirmButtonText: 'Yes, Delete'
    }).then(function(r) {
        if (r.isConfirmed) {
            $.ajax({
                url: '/Staff/staffdeletestudent/' + id, type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function() {
                    Swal.fire({ icon: 'success', title: 'Deleted!', confirmButtonColor: '#696cff' });
                    $('#staff-student-table').DataTable().ajax.reload();
                }
            });
        }
    });
}
</script>
@endpush
