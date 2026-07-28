<?php
// Quick check of Yajra DataTables response
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Staff;
use Yajra\DataTables\DataTables;

$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
$_GET = [
    'draw'=>'1','start'=>'0','length'=>'25',
    'search'=>['value'=>'','regex'=>'false'],
    'order'=>[['column'=>'0','dir'=>'asc']],
    'columns'=>[
        ['data'=>'DT_RowIndex','name'=>'DT_RowIndex','searchable'=>'false','orderable'=>'false','search'=>['value'=>'','regex'=>'false']],
        ['data'=>'created_at','name'=>'created_at','searchable'=>'true','orderable'=>'true','search'=>['value'=>'','regex'=>'false']],
        ['data'=>'staff_id','name'=>'staff_id','searchable'=>'true','orderable'=>'true','search'=>['value'=>'','regex'=>'false']],
        ['data'=>'staff_name','name'=>'staff_name','searchable'=>'true','orderable'=>'true','search'=>['value'=>'','regex'=>'false']],
        ['data'=>'mobile','name'=>'mobile','searchable'=>'true','orderable'=>'true','search'=>['value'=>'','regex'=>'false']],
        ['data'=>'email','name'=>'email','searchable'=>'true','orderable'=>'true','search'=>['value'=>'','regex'=>'false']],
        ['data'=>'role_name','name'=>'role_name','searchable'=>'true','orderable'=>'true','search'=>['value'=>'','regex'=>'false']],
        ['data'=>'status','name'=>'status','searchable'=>'false','orderable'=>'false','search'=>['value'=>'','regex'=>'false']],
        ['data'=>'action','name'=>'action','searchable'=>'false','orderable'=>'false','search'=>['value'=>'','regex'=>'false']],
    ]
];

header('Content-Type: application/json');
try {
    $staff = Staff::select(['id','staff_name','staff_id','mobile','email','role_name','status','created_at']);
    $r = DataTables::of($staff)
        ->addIndexColumn()
        ->editColumn('created_at', fn($row) => $row->created_at->format('d-m-Y'))
        ->addColumn('status', fn($row) => $row->status)
        ->addColumn('action', fn($row) => 'ACTION_'.$row->id)
        ->rawColumns(['status','action'])
        ->make(true);
    echo $r->getContent();
} catch(\Exception $e) {
    echo json_encode(['FATAL_ERROR' => $e->getMessage(), 'line' => $e->getLine()]);
}
