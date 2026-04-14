<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AdministrationLog;
use Auth;

class AdministrationLogController extends Controller
{
    public function get_logs(Request $request) 
    {
        // 1. Permission Check: Only Admin (Role 1)
        if (Auth::user()->role != 1) {
            return response()->json(['html' => '<div class="alert alert-danger">Unauthorized Access</div>'], 403);
        }

        // 2. Filter Logs
        $query = AdministrationLog::query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        
        // Use with('user') if you want to show user names, assuming relationship exists or we use user_id
        $logs = $query->latest()->limit(50)->get();

        // 3. Build HTML Output (Simpler than sending JSON and building in JS)
        $html = '<table class="table table-striped table-bordered">';
        $html .= '<thead><tr><th>Date</th><th>User</th><th>Action</th><th>Details</th></tr></thead>';
        $html .= '<tbody>';
        
        foreach($logs as $log) {
            $userName = $log->user_id ? (\App\Models\User::find($log->user_id)->user_name ?? 'Unknown') : 'System';
            $html .= '<tr>';
            $html .= '<td>' . $log->created_at . '</td>';
            $html .= '<td>' . $userName . '</td>';
            $html .= '<td>' . $log->action . '</td>';
            $html .= '<td>' . htmlspecialchars($log->details) . '</td>';
            $html .= '</tr>';
        }
        
        if($logs->isEmpty()){
             $html .= '<tr><td colspan="4" class="text-center">No logs found.</td></tr>';
        }

        $html .= '</tbody></table>';

        return response()->json(['html' => $html]);
    }
}
