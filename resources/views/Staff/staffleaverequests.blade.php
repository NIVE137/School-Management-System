@extends('Staff.stafflayout')

@section('content')
<style>
.page-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px; }
.custom-card { background:var(--bs-card-bg,#fff); border-radius:14px; border:1px solid rgba(231,231,255,0.8); box-shadow:0 2px 20px rgba(105,108,255,0.08); padding:24px; }
.btn-cyan { background:linear-gradient(135deg,#696cff,#03c3ec)!important; color:#fff!important; border:none!important; font-weight:600; padding:9px 18px; border-radius:8px; font-size:0.875rem; transition:all .2s; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; }
.btn-cyan:hover { box-shadow:0 6px 20px rgba(105,108,255,0.38)!important; transform:translateY(-1px); }
</style>

<div class="page-header">
    <div>
        <h4 class="fw-bold mb-0">My Leave Applications</h4>
        <small class="text-muted">Apply for leave and track approval status</small>
    </div>
    <div>
        <button class="btn-cyan" data-bs-toggle="modal" data-bs-target="#applyLeaveModal">
            <i class="fa-solid fa-plus"></i> Apply for Leave
        </button>
    </div>
</div>

<div class="custom-card">
    <div class="table-responsive">
        <table class="table table-custom table-borderless align-middle w-100" id="staff-leave-table">
            <thead>
                <tr>
                    <th class="text-center" style="width:50px;">#</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Reason</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Apply Leave Modal -->
<div class="modal fade" id="applyLeaveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3" style="border-radius:14px;border:none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Submit Leave Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="apply-leave-form">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Leave Type</label>
                        <select name="leave_type" class="form-select" required>
                            <option value="Casual Leave">Casual Leave</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Earned Leave">Earned Leave</option>
                            <option value="Emergency Leave">Emergency Leave</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Start Date</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">End Date</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Reason</label>
                        <textarea name="reason" class="form-control" rows="3" required placeholder="Explain why you are applying for leave..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    var table = $('#staff-leave-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("staffleaverequests") }}'
        },
        columns: [
            { data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'leave_type',   name: 'leave_type', className: 'fw-semibold' },
            { data: 'start_date',   name: 'start_date' },
            { data: 'end_date',     name: 'end_date' },
            { data: 'reason',       name: 'reason' },
            { data: 'status_badge', name: 'status',     className: 'text-center', orderable: false }
        ],
        language: { search: '_INPUT_', searchPlaceholder: 'Search applications...' }
    });

    $('#apply-leave-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("staffstoreleaverequest") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                $('#applyLeaveModal').modal('hide');
                toastr.success(res.message);
                table.ajax.reload();
            },
            error: function (xhr) {
                toastr.error(xhr.responseJSON?.message || 'Error submitting leave application');
            }
        });
    });
});
</script>
@endpush
