<?php

namespace App\traits;

use App\Models\AdministrationLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Trait LogsActivity
 *
 * Use in any controller: use App\traits\LogsActivity;
 *
 * $this->writeLog('Report', 'User searched CM report | Date: 2024-01-01', 'Search', 'CM Report');
 */
trait LogsActivity
{
    /**
     * Write an administration log entry.
     *
     * @param string      $category  User | Group | Workflow | Report | Category
     * @param string      $details   Human-readable description
     * @param string      $action    Create | Update | Delete | Search | Export | View | Login | Logout
     * @param string|null $section   Sub-section label e.g. "CM Report", "Custom Fields"
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
            \Log::warning('AdministrationLog write failed: ' . $e->getMessage());
        }
    }

    /**
     * Build a readable summary string from request inputs.
     * Skips null / empty values.
     *
     * Example: "Creator Id: john | Status: Pending | Group Id: 3"
     */
    protected function formatRequestDetails(array $inputs, array $skip = ['_token', '_method']): string
    {
        $parts = [];
        foreach ($inputs as $key => $value) {
            if (in_array($key, $skip) || $value === null || $value === '') {
                continue;
            }
            $label   = ucwords(str_replace('_', ' ', $key));
            $parts[] = "{$label}: " . (is_array($value) ? implode(', ', $value) : $value);
        }
        return implode(' | ', $parts) ?: 'No filters applied';
    }
}
