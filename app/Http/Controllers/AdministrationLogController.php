<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdministrationLog;
use App\Models\User;
use Auth;

class AdministrationLogController extends Controller
{
    /**
     * Return logs as JSON (HTML table) for a given category.
     * Called via AJAX when the user clicks a "Logs" button on any page.
     *
     * Query params:
     *   ?category=Report|User|Group|Workflow
     *   &section=CM+Report          (optional)
     *   &action=Search|Export|...   (optional)
     *   &limit=100                  (optional, default 100)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_logs(Request $request)
    {
        // Only Admin (role 1) may view logs
        if (Auth::user()->role != 1) {
            return response()->json([
                'html' => '<div class="alert alert-danger">Unauthorized Access</div>'
            ], 403);
        }

        $query = AdministrationLog::query()->with('user');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $limit = (int) $request->input('limit', 100);
        $logs  = $query->latest()->limit($limit)->get();

        // ── Build HTML table ───────────────────────────────────────────────
        $html  = '<div class="table-responsive">';
        $html .= '<table class="table table-striped table-bordered table-sm" style="font-size:13px">';
        $html .= '<thead class="thead-dark">';
        $html .= '<tr>';
        $html .= '<th style="white-space:nowrap">#</th>';
        $html .= '<th style="white-space:nowrap">Date &amp; Time</th>';
        $html .= '<th style="white-space:nowrap">User</th>';
        $html .= '<th style="white-space:nowrap">Category</th>';
        $html .= '<th style="white-space:nowrap">Section</th>';
        $html .= '<th style="white-space:nowrap">Action</th>';
        $html .= '<th>Details</th>';
        $html .= '<th style="white-space:nowrap">IP Address</th>';
        $html .= '</tr>';
        $html .= '</thead><tbody>';

        foreach ($logs as $i => $log) {
            $userName = optional($log->user)->user_name ?? 'System';

            // Action badge colour
            $badgeMap = [
                'Create' => 'success',
                'Update' => 'warning',
                'Delete' => 'danger',
                'Search' => 'info',
                'Export' => 'primary',
                'View'   => 'secondary',
                'Login'  => 'dark',
                'Logout' => 'dark',
            ];
            $badge = $badgeMap[$log->action] ?? 'secondary';

            $html .= '<tr>';
            $html .= '<td>' . ($i + 1) . '</td>';
            $html .= '<td style="white-space:nowrap">' . $log->created_at->format('Y-m-d H:i:s') . '</td>';
            $html .= '<td>' . htmlspecialchars($userName) . '</td>';
            $html .= '<td>' . htmlspecialchars($log->category ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($log->section ?? '-') . '</td>';
            $html .= '<td><span class="badge badge-' . $badge . '">' . htmlspecialchars($log->action) . '</span></td>';
            $html .= '<td>' . $log->formatted_details . '</td>';
            $html .= '<td style="white-space:nowrap">' . htmlspecialchars($log->ip_address ?? '-') . '</td>';
            $html .= '</tr>';
        }

        if ($logs->isEmpty()) {
            $html .= '<tr><td colspan="8" class="text-center text-muted py-3">No logs found for this section.</td></tr>';
        }

        $html .= '</tbody></table></div>';

        return response()->json(['html' => $html]);
    }
}
