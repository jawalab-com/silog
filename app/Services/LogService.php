<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogService
{
    /**
     * Create a new log entry.
     */
    public function createLogEntry(string $type, string $message, string $severity = 'info', array $context = []): void
    {
        Log::create([
            'log_type' => $type,
            'message' => $message,
            'severity' => $severity,
            'user_id' => Auth::id(), // Get the authenticated user ID
            'ip_address' => request()->ip(), // Get the IP address of the request
            'context' => $context, // Additional context as an array
        ]);
    }
}
