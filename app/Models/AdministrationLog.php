<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrationLog extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'section',
        'action',
        'details',
        'ip_address',
        'user_agent',
    ];

    /**
     * Categories available in the system.
     * User | Group | Workflow | Report
     */
    const CATEGORIES = ['User', 'Group', 'Workflow', 'Report'];

    /**
     * Actions available in the system.
     */
    const ACTIONS = ['Create', 'Update', 'Delete', 'Search', 'Export', 'View', 'Login', 'Logout'];

    /**
     * Belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Format the details field as human-readable text.
     * If the details is a JSON string, decode and format it.
     */
    public function getFormattedDetailsAttribute()
    {
        $decoded = json_decode($this->details, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $lines = [];
            foreach ($decoded as $key => $value) {
                if (!empty($value)) {
                    $label = ucwords(str_replace('_', ' ', $key));
                    $lines[] = "<strong>{$label}:</strong> " . htmlspecialchars($value);
                }
            }
            return implode('<br>', $lines);
        }

        return htmlspecialchars($this->details ?? '');
    }
}
