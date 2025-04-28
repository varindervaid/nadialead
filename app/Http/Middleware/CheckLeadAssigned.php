<?php

namespace App\Http\Middleware;

use App\Models\LeadAssigned;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ApiResponse;
class CheckLeadAssigned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $user_role = $user->roles->first()?->name;

        if ($user_role == 'client') {
            // Get the lead ID from the route
            $leadId = $request->route('id');

            // Get the authenticated user

            // Check if the lead exists and if the user is assigned to this lead
            $assignedLead = LeadAssigned::where('lead_id', $leadId)->where('user_id', $user->id)->first();

            if (!$assignedLead) {
                // Lead doesn't exist
                return ApiResponse::error('Lead not found.', 404);
            }

            // Check if the current user is assigned to this lead
            if ($assignedLead->user_id !== $user->id) {
                // User is not assigned to this lead
                return ApiResponse::error('You are not authorized to edit this lead.', 403);
            }
        }

        return $next($request);
    }
}
