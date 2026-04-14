<?php

namespace App\traits;

use App\Models\AdministrationLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Trait LogsActivity
 *
 * Use this trait in any controller to get access to the writeLog() helper.
 *
 * Usage:
 *   use App\traits\LogsActivity;
 *   ...
 *   $this->writeLog('Report', 'User entered date range', 'Search', 'CM Report');
 */
trait LogsActivity
{
    /**
     * Write an administration log entry.
     *
     * @param string      $category  User | Group | Workflow | Report
     * @param string      $details   Human-readable description of what happened
     * @param string      $action    Create | Update | Delete | Search | Export | View | Login | Logout
     * @param string|null $section   Sub-section label (optional, e.g. "CM Report", "Enterprise Report")
     */
    protected function writeLog(string $category, string $details, string $action = 'View', ?string $section = null): void
    {
        try {
            AdministrationLog::create([
                'user_id'    => Auth::id(),
                'category'   => $category,
                'section'    => $section,
                'action'     => $action,
                'details'    => $details,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        } catch (\Exception $e) {
            // Never let logging crash the application
            \Log::warning('AdministrationLog write failed: ' . $e->getMessage());
        }
    }

    /**
     * Build a readable summary string from a request's input array.
     * Null / empty values are omitted.
     *
     * Example output:
     *   "Creator Id: john.doe | Status: Pending | Group Id: 3"
     */
    protected function formatRequestDetails(array $inputs, array $skip = ['_token', '_method']): string
    {
        $parts = [];
        foreach ($inputs as $key => $value) {
            if (in_array($key, $skip) || $value === null || $value === '') {
                continue;
            }
            $label = ucwords(str_replace('_', ' ', $key));
            $parts[] = "{$label}: " . (is_array($value) ? implode(', ', $value) : $value);
        }
        return implode(' | ', $parts) ?: 'No filters applied';
    }
}
