<?php

namespace App\Traits;

use App\Models\ApplicationView;
use Illuminate\Http\Request;

trait TracksApplicationViews 
{
    protected function trackApplicationAction($applicationId, $actionType, Request $request)
    {
        try {
            $user = auth('admin')->user(); 
            
            ApplicationView::create([
                'application_id' => $applicationId,
                'user_id' => $user ? $user->uuid : null,
                'user_type' => $user ? ($user->type ?? 'admin') : 'guest',
                'user_name' => $user ? $user->username : 'Guest',
                'action_type' => $actionType,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'viewed_at' => now()
            ]);
        } catch (\Exception $e) {
            // Log the error but don't break the application flow
            \Log::error('Failed to track application action: ' . $e->getMessage());
        }
    }
}