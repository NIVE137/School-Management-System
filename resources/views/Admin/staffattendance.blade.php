@extends('Admin.layout')

@section('content')
<style>
.page-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px; }
.custom-card { background:var(--bs-card-bg,#fff); border-radius:14px; border:1px solid rgba(231,231,255,0.8); box-shadow:0 2px 20px rgba(105,108,255,0.08); padding:24px; }
.btn-cyan { background:linear-gradient(135deg,#696cff,#03c3ec)!important; color:#fff!important; border:none!important; font-weight:600; padding:9px 18px; border-radius:8px; font-size:0.875rem; transition:all .2s; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
.btn-cyan:hover { box-shadow:0 6px 20px rgba(105,108,255,0.38)!important; transform:translateY(-1px); }
</style>

<div class="page-header">
    <div>
        <h4 class="fw-bold mb-0">Staff Attendance</h4>
        <small class="text-muted">View, mark and manage daily staff attendance logs</small>
    </div>
    <div class="d-flex gap-2">
        <button class="btn-cyan" data-bs-toggle="modal" data-bs-target="#markStaffAttendanceModal">
            <i class="fa-solid fa-clock"></i> Mark Staff Attendance
        </button>
    </div>
</div>

<div class="custom-card mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-md-4">
            <label class="form-label fw-semibold">Select Date</label>
            <input type="date" id="filter-date" class="form-control" value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Filter Status</label>
            <select id="filter-status" class="form-select">
                <option value="">All Statuses</option>
                <option value="present">Present</option>
                <option value="absent">Absent</option>
                <option value="late">Late</option>
                <option value="leave">On Leave</option>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button id="btn-filter" class="btn btn-primary w-100 mt-4"><i class="fas fa-filter me-1"></i> Apply Filter</button>
        </div>
    </div>
</div>

<div class="custom-card">
    <div class="table-responsive">
        <table class="table table-custom table-borderless align-middle w-100" id="staff-attendance-table">
            <thead>
                <tr>
                    <th class="text-center" style="width:50px;">#</th>
                    <th>Date</th>
                    <th>Staff Name</th>
                    <th>Role</th>
                    <th class="text-center">Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Mark Staff Attendance Modal -->
<div class="modal fade" id="markStaffAttendanceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3" style="border-radius:14px;border:none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Mark Staff Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="mark-staff-attendance-form">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Staff Member</label>
                        <select name="staff_id" class="form-select" required>
                            <option value="">-- Choose Staff --</option>
                            @foreach($staffMembers as $st)
                                <option value="{{ $st->id }}">{{ $st->staff_name }} ({{ $st->role_name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="late">Late</option>
                            <option value="leave">On Leave</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Remarks (Optional)</label>
                        <input type="text" name="remarks" class="form-control" placeholder="e.g. Approved half day">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    var table = $('#staff-attendance-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("staffattendance") }}',
            data: function (d) {
                d.date = $('#filter-date').val();
                d.status = $('#filter-status').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'date',         name: 'date' },
            { data: 'staff_name',   name: 'staff_name', className: 'fw-semibold' },
            { data: 'role_name',    name: 'role_name' },
            { data: 'status_badge', name: 'status',     className: 'text-center', orderable: false },
            { data: 'remarks',      name: 'remarks' }
        ],
        language: { search: '_INPUT_', searchPlaceholder: 'Search staff attendance...' }
    });

    $('#btn-filter').on('click', function () {
        table.ajax.reload();
    });

    $('#mark-staff-attendance-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("markstaffattendance") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                $('#markStaffAttendanceModal').modal('hide');
                toastr.success(res.message);
                table.ajax.reload();
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.message || 'Error marking attendance');
            }
        });
    });
});
</script>
@endpush
