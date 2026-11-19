<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        $activities = ActivityLog::query()
            ->select('activity_logs.*');

        if ($request->ajax()) {

            return DataTables::of($activities)
                ->addIndexColumn()

                ->editColumn('action', function ($activity) {

                    $badges = [
                        'created' => 'success',
                        'updated' => 'primary',
                        'deleted' => 'danger',
                        'status_updated' => 'warning',
                    ];

                    $color = $badges[$activity->action] ?? 'secondary';

                    $label = ucwords(str_replace('_', ' ', $activity->action));

                    return '<span class="badge bg-'.$color.'">'.$label.'</span>';
                })

                ->editColumn('created_at', function ($activity) {
                    return $activity->created_at
                        ? $activity->created_at->format('d M Y, h:i A')
                        : 'N/A';
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('activity-logs.index');
    }
}
