@extends('Admin.layout')

@section('content')
<style>
/* ─── Modern Dashboard Styles ─────────────────────────────── */
.dash-hero {
    background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 45%, #0369a1 100%);
    border-radius: 16px;
    padding: 32px 36px;
    color: #fff;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
    min-height: 148px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 10px 30px rgba(29,78,216,0.22);
}
.dash-hero::before {
    content: ''; position: absolute; top: -60px; right: -60px;
    width: 260px; height: 260px; border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.dash-hero-left { position: relative; z-index: 1; }
.dash-hero h2 { font-size: 1.55rem; font-weight: 800; margin-bottom: 6px; letter-spacing: -0.4px; }
.dash-hero p  { font-size: 0.9rem; color: rgba(255,255,255,0.72); margin: 0; }
.dash-hero-actions { position: relative; z-index: 1; display: flex; gap: 10px; flex-wrap: wrap; }
.hero-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 18px; border-radius: 9px; font-size: 0.82rem;
    font-weight: 700; text-decoration: none; transition: all 0.2s; cursor: pointer; border: none;
}
.hero-btn.white { background: #fff; color: #1e3a8a; }
.hero-btn.white:hover { background: #eff6ff; box-shadow: 0 6px 18px rgba(0,0,0,0.15); transform: translateY(-1px); color: #1e3a8a; }
.hero-btn.outline { background: rgba(255,255,255,0.12); color: #fff; border: 1.5px solid rgba(255,255,255,0.25); }
.hero-btn.outline:hover { background: rgba(255,255,255,0.20); color: #fff; }

.date-chip {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.22);
    border-radius: 20px; padding: 5px 14px; font-size: 0.76rem;
    font-weight: 600; color: rgba(255,255,255,0.85); margin-bottom: 12px;
}

/* Stat Cards */
.stat-card {
    background: var(--bs-card-bg, #fff);
    border-radius: 14px;
    padding: 22px 20px;
    border: 1px solid rgba(231,231,255,0.8);
    box-shadow: 0 2px 16px rgba(99,102,241,0.07);
    transition: transform 0.22s, box-shadow 0.22s;
    position: relative; overflow: hidden;
    text-decoration: none; display: block;
}
.stat-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3.5px;
    border-radius: 14px 14px 0 0;
}
.stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(99,102,241,0.18); text-decoration: none; }
.stat-card:active { transform: scale(0.98); }

.stat-card.c1::before { background: linear-gradient(90deg,#6366f1,#818cf8); }
.stat-card.c2::before { background: linear-gradient(90deg,#0ea5e9,#38bdf8); }
.stat-card.c3::before { background: linear-gradient(90deg,#10b981,#34d399); }
.stat-card.c4::before { background: linear-gradient(90deg,#f59e0b,#fbbf24); }
.stat-card.c5::before { background: linear-gradient(90deg,#8b5cf6,#a78bfa); }
.stat-card.c6::before { background: linear-gradient(90deg,#ec4899,#f472b6); }

.stat-icon {
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.35rem; margin-bottom: 14px;
}
.stat-card.c1 .stat-icon { background: rgba(99,102,241,0.10); color: #6366f1; }
.stat-card.c2 .stat-icon { background: rgba(14,165,233,0.10); color: #0ea5e9; }
.stat-card.c3 .stat-icon { background: rgba(16,185,129,0.10); color: #10b981; }
.stat-card.c4 .stat-icon { background: rgba(245,158,11,0.10); color: #f59e0b; }
.stat-card.c5 .stat-icon { background: rgba(139,92,246,0.10); color: #8b5cf6; }
.stat-card.c6 .stat-icon { background: rgba(236,72,153,0.10); color: #ec4899; }

.stat-label { font-size: 0.74rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.9px; color: #94a3b8; margin-bottom: 4px; }
.stat-value { font-size: 2rem; font-weight: 900; line-height: 1; margin-bottom: 10px; }
.stat-footer { font-size: 0.74rem; font-weight: 600; padding-top: 10px; border-top: 1px solid rgba(241,241,249,0.8); }

/* Bottom Cards */
.bottom-card {
    background: var(--bs-card-bg, #fff); border-radius: 14px;
    border: 1px solid rgba(231,231,255,0.8);
    box-shadow: 0 2px 16px rgba(99,102,241,0.07);
    padding: 24px;
    height: 100%;
}
.section-heading {
    font-size: 0.75rem; font-weight: 800; text-transform: uppercase;
    letter-spacing: 1px; color: #94a3b8; margin-bottom: 18px;
    padding-bottom: 12px; border-bottom: 2px solid rgba(241,241,249,0.8);
    display: flex; align-items: center; gap: 8px;
}
.section-heading::before {
    content: ''; width: 3px; height: 14px;
    background: linear-gradient(#6366f1,#0ea5e9);
    border-radius: 2px; display: inline-block;
}

/* Quick Actions */
.qa-btn {
    display: flex; align-items: center; gap: 12px;
    padding: 13px 16px; border-radius: 10px;
    border: 1.5px solid rgba(231,231,255,0.8); text-decoration: none;
    color: inherit; font-size: 0.85rem; font-weight: 600;
    transition: all 0.2s; margin-bottom: 10px;
}
.qa-btn:hover { border-color: #6366f1; background: rgba(99,102,241,0.05); color: #6366f1; transform: translateX(3px); }
.qa-btn .qa-icon {
    width: 38px; height: 38px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;
}

/* Activity Items */
.activity-item { display: flex; align-items: flex-start; gap: 12px; padding: 10px 0; border-bottom: 1px solid rgba(241,241,249,0.8); }
.activity-item:last-child { border-bottom: none; }
.a-dot { width: 8px; height: 8px; border-radius: 50%; margin-top: 6px; flex-shrink: 0; }
.a-text { font-size: 0.83rem; line-height: 1.4; font-weight: 500; }
.a-time { font-size: 0.72rem; color: #94a3b8; margin-top: 2px; }
</style>

<div class="container-fluid px-0">

    <!-- Hero Banner -->
    <div class="dash-hero mb-4">
        <div class="dash-hero-left">
            <div class="date-chip">
                <i class="fas fa-calendar-day"></i>
                <span id="hero-date">Loading...</span>
            </div>
            <h2>Welcome back, Administrator 👋</h2>
            <p>Live overview of staff, students, attendance & leave applications.</p>
        </div>
        <div class="dash-hero-actions">
            <a href="{{ route('createstaff') }}" class="hero-btn white"><i class="fas fa-user-plus"></i> Add Staff</a>
            <a href="{{ route('createstudent') }}" class="hero-btn outline"><i class="fas fa-graduation-cap"></i> Add Student</a>
        </div>
    </div>

    <!-- Live Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <a href="{{ route('staffmanagement') }}" class="stat-card c1">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-label">Total Staff</div>
                <div class="stat-value">{{ $staffCount ?? 0 }}</div>
                <div class="stat-footer text-primary"><i class="fas fa-arrow-right me-1"></i>Manage Staff</div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <a href="{{ route('studentmanagement') }}" class="stat-card c2">
                <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-label">Total Students</div>
                <div class="stat-value">{{ $studentCount ?? 0 }}</div>
                <div class="stat-footer text-info"><i class="fas fa-arrow-right me-1"></i>Manage Students</div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <a href="{{ route('staffattendance') }}" class="stat-card c3">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-label">Staff Present</div>
                <div class="stat-value">{{ $staffPresentCount ?? 0 }}</div>
                <div class="stat-footer text-success"><i class="fas fa-eye me-1"></i>View Attendance</div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <a href="{{ route('studentattendance') }}" class="stat-card c4">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-label">Students Present</div>
                <div class="stat-value">{{ $studentPresentCount ?? 0 }}</div>
                <div class="stat-footer text-warning"><i class="fas fa-eye me-1"></i>View Attendance</div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <a href="{{ route('createclass') }}" class="stat-card c5">
                <div class="stat-icon"><i class="fas fa-building-columns"></i></div>
                <div class="stat-label">Total Classes</div>
                <div class="stat-value">{{ $classCount ?? 0 }}</div>
                <div class="stat-footer text-purple"><i class="fas fa-arrow-right me-1"></i>Manage Classes</div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
            <a href="{{ route('leaverequests') }}" class="stat-card c6">
                <div class="stat-icon"><i class="fas fa-calendar-minus"></i></div>
                <div class="stat-label">Pending Leaves</div>
                <div class="stat-value">{{ $pendingLeaveCount ?? 0 }}</div>
                <div class="stat-footer text-danger"><i class="fas fa-check-double me-1"></i>Review Requests</div>
            </a>
        </div>
    </div>

    <!-- Charts & Quick Action Row -->
    <div class="row g-3 mb-4">
        <!-- Interactive Chart -->
        <div class="col-xl-8 col-lg-12">
            <div class="bottom-card">
                <div class="section-heading">Attendance & Activity Distribution</div>
                <div id="attendanceChart" style="min-height: 280px;"></div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xl-4 col-lg-12">
            <div class="bottom-card">
                <div class="section-heading">Quick Actions</div>
                <a href="{{ route('createstaff') }}" class="qa-btn">
                    <div class="qa-icon" style="background:rgba(99,102,241,0.1);color:#6366f1;"><i class="fas fa-user-plus"></i></div>
                    Add New Staff Member
                </a>
                <a href="{{ route('createstudent') }}" class="qa-btn">
                    <div class="qa-icon" style="background:rgba(14,165,233,0.1);color:#0ea5e9;"><i class="fas fa-graduation-cap"></i></div>
                    Add New Student
                </a>
                <a href="{{ route('studentattendance') }}" class="qa-btn">
                    <div class="qa-icon" style="background:rgba(16,185,129,0.1);color:#10b981;"><i class="fas fa-calendar-check"></i></div>
                    Mark Student Attendance
                </a>
                <a href="{{ route('leaverequests') }}" class="qa-btn">
                    <div class="qa-icon" style="background:rgba(236,72,153,0.1);color:#ec4899;"><i class="fas fa-calendar-minus"></i></div>
                    Review Pending Leaves
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity Row -->
    <div class="row g-3">
        <div class="col-xl-6 col-lg-12">
            <div class="bottom-card">
                <div class="section-heading">Recent Staff Additions</div>
                @forelse($recentStaff as $st)
                    <div class="activity-item">
                        <div class="a-dot" style="background:#6366f1;"></div>
                        <div>
                            <div class="a-text">{{ $st->staff_name }} — <span class="text-muted">{{ $st->role_name }}</span></div>
                            <div class="a-time">ID: {{ $st->staff_id }} | Added: {{ $st->created_at ? $st->created_at->diffForHumans() : 'Recently' }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-muted py-2">No recent staff members added.</div>
                @endforelse
            </div>
        </div>

        <div class="col-xl-6 col-lg-12">
            <div class="bottom-card">
                <div class="section-heading">Recent Leave Applications</div>
                @forelse($recentLeaves as $lv)
                    <div class="activity-item">
                        <div class="a-dot" style="background:#ec4899;"></div>
                        <div>
                            <div class="a-text">{{ $lv->applicant_name }} ({{ $lv->leave_type }})</div>
                            <div class="a-time">{{ $lv->start_date }} to {{ $lv->end_date }} — <span class="badge bg-label-warning">{{ ucfirst($lv->status) }}</span></div>
                        </div>
                    </div>
                @empty
                    <div class="text-muted py-2">No recent leave requests.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    const d = new Date();
    const opts = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
    const el = document.getElementById('hero-date');
    if (el) el.textContent = d.toLocaleDateString('en-US', opts);

    /* Render ApexChart */
    var options = {
        series: [{
            name: 'Staff Present',
            data: [{{ $staffPresentCount }}, {{ max(0, $staffPresentCount - 1) }}, {{ $staffPresentCount }}, {{ $staffPresentCount }}]
        }, {
            name: 'Students Present',
            data: [{{ $studentPresentCount }}, {{ max(0, $studentPresentCount - 1) }}, {{ $studentPresentCount }}, {{ $studentPresentCount }}]
        }],
        chart: { type: 'bar', height: 280, toolbar: { show: false } },
        colors: ['#6366f1', '#10b981'],
        plotOptions: { bar: { horizontal: false, columnWidth: '45%', borderRadius: 6 } },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 2, colors: ['transparent'] },
        xaxis: { categories: ['Mon', 'Tue', 'Wed', 'Thu'] },
        fill: { opacity: 1 },
        tooltip: { y: { formatter: function (val) { return val + " present"; } } }
    };
    var chart = new ApexCharts(document.querySelector("#attendanceChart"), options);
    chart.render();
</script>
@endpush
@endsection
