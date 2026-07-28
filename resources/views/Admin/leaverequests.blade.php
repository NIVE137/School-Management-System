@extends('Admin.layout')

@section('content')
<style>
.page-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px; }
.custom-card { background:var(--bs-card-bg,#fff); border-radius:14px; border:1px solid rgba(231,231,255,0.8); box-shadow:0 2px 20px rgba(105,108,255,0.08); padding:24px; }
</style>

<div class="page-header">
    <div>
        <h4 class="fw-bold mb-0">Leave Requests</h4>
        <small class="text-muted">Review, approve, or reject staff and student leave applications</small>
    </div>
</div>

<div class="custom-card mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-md-6">
            <label class="form-label fw-semibold">Filter by Status</label>
            <select id="filter-status" class="form-select">
                <option value="">All Statuses</option>
                <option value="pending" selected>Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        <div class="col-md-6 d-flex align-items-end">
            <button id="btn-filter" class="btn btn-primary w-100 mt-4"><i class="fas fa-filter me-1"></i> Apply Filter</button>
        </div>
    </div>
</div>

<div class="custom-card">
    <div class="table-responsive">
        <table class="table table-custom table-borderless align-middle w-100" id="leave-table">
            <thead>
                <tr>
                    <th class="text-center" style="width:50px;">#</th>
                    <th>Applicant</th>
                    <th>Type</th>
                    <th>Leave Dates</th>
                    <th>Reason</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" style="width:120px;">Action</th>
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
    var table = $('#leave-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("leaverequests") }}',
            data: function (d) {
                d.status = $('#filter-status').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex',     name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'applicant_name', name: 'applicant_name', className: 'fw-semibold' },
            { data: 'leave_type',      name: 'leave_type' },
            { data: 'start_date',      name: 'start_date', render: function(d, t, r){ return d + ' to ' + r.end_date; } },
            { data: 'reason',          name: 'reason' },
            { data: 'status_badge',    name: 'status', className: 'text-center', orderable: false },
            { data: 'action',          name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        language: { search: '_INPUT_', searchPlaceholder: 'Search leave requests...' }
    });

    $('#btn-filter').on('click', function () {
        table.ajax.reload();
    });
});

function approveLeave(id) {
    Swal.fire({
        title: 'Approve Leave Request?',
        text: 'Are you sure you want to approve this leave application?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4caf50',
        confirmButtonText: 'Yes, Approve'
    }).then(function(r) {
        if (r.isConfirmed) {
            $.ajax({
                url: '/Admin/approveleaverequest/' + id,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(res) {
                    toastr.success(res.message);
                    $('#leave-table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    toastr.error('Error approving request');
                }
            });
        }
    });
}

function rejectLeave(id) {
    Swal.fire({
        title: 'Reject Leave Request',
        input: 'textarea',
        inputLabel: 'Reason for Rejection',
        inputPlaceholder: 'Enter rejection reason here...',
        showCancelButton: true,
        confirmButtonColor: '#ff3e1d',
        confirmButtonText: 'Reject Request'
    }).then(function(r) {
        if (r.isConfirmed && r.value) {
            $.ajax({
                url: '/Admin/rejectleaverequest/' + id,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', rejection_reason: r.value },
                success: function(res) {
                    toastr.success(res.message);
                    $('#leave-table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    toastr.error('Error rejecting request');
                }
            });
        }
    });
}
</script>
@endpush
