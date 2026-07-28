@extends('Staff.stafflayout')

@section('content')
<style>
.page-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px; }
.custom-card { background:var(--bs-card-bg,#fff); border-radius:14px; border:1px solid rgba(231,231,255,0.8); box-shadow:0 2px 20px rgba(105,108,255,0.08); padding:24px; }
</style>

<div class="page-header">
    <div>
        <h4 class="fw-bold mb-0">Student Attendance Records</h4>
        <small class="text-muted">View daily student attendance logs</small>
    </div>
</div>

<div class="custom-card mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-md-5">
            <label class="form-label fw-semibold">Select Date</label>
            <input type="date" id="filter-date" class="form-control" value="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-5">
            <label class="form-label fw-semibold">Class</label>
            <select id="filter-class" class="form-select">
                <option value="">All Classes</option>
                @foreach($classes as $c)
                    <option value="{{ $c->class_name }}">{{ $c->class_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button id="btn-filter" class="btn btn-primary w-100 mt-4"><i class="fas fa-filter"></i> Filter</button>
        </div>
    </div>
</div>

<div class="custom-card">
    <div class="table-responsive">
        <table class="table table-custom table-borderless align-middle w-100" id="staff-student-attendance-table">
            <thead>
                <tr>
                    <th class="text-center" style="width:50px;">#</th>
                    <th>Date</th>
                    <th>Student Name</th>
                    <th class="text-center">Class</th>
                    <th class="text-center">Status</th>
                    <th>Remarks</th>
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
    var table = $('#staff-student-attendance-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("staffstudentattendance") }}',
            data: function (d) {
                d.date = $('#filter-date').val();
                d.class_name = $('#filter-class').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'date',         name: 'date' },
            { data: 'student_name', name: 'student_name', className: 'fw-semibold' },
            { data: 'class_name',   name: 'class_name',   className: 'text-center fw-semibold' },
            { data: 'status_badge', name: 'status',       className: 'text-center', orderable: false },
            { data: 'remarks',      name: 'remarks' }
        ],
        language: { search: '_INPUT_', searchPlaceholder: 'Search...' }
    });

    $('#btn-filter').on('click', function () {
        table.ajax.reload();
    });
});
</script>
@endpush
