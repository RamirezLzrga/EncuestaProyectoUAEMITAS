<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey;
use App\Models\ActivityLog;

class AdminApprovalController extends Controller
{
    public function index()
    {
        $pendingSurveys = Survey::with('user')
            ->where('approval_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $history = Survey::with(['user', 'approver'])
            ->whereIn('approval_status', ['approved', 'rejected'])
            ->orderBy('approved_at', 'desc')
            ->limit(30)
            ->get();

        return view('admin.aprobaciones', [
            'pendingSurveys' => $pendingSurveys,
            'history' => $history,
        ]);
    }

    public function updateStatus(Request $request, Survey $survey)
    {
        $request->validate([
            'decision' => 'required|in:approve,reject',
            'comment' => 'nullable|string|max:500',
        ]);

        $decision = $request->input('decision');
        $comment = $request->input('comment');

        $survey->approval_status = $decision === 'approve' ? 'approved' : 'rejected';
        $survey->approval_comment = $comment;
        $survey->approved_by = Auth::id();
        $survey->approved_at = now();
        $survey->is_active = $decision === 'approve';
        $survey->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'action' => $decision === 'approve' ? 'approve' : 'reject',
            'description' => ($decision === 'approve' ? 'Aprobó encuesta: ' : 'Rechazó encuesta: ') . $survey->title,
            'type' => 'survey',
            'ip_address' => $request->ip(),
            'details' => [
                'survey_id' => $survey->id,
                'approval_status' => $survey->approval_status,
            ],
        ]);

        return redirect()
            ->route('admin.aprobaciones')
            ->with('success', $decision === 'approve' ? 'Encuesta aprobada correctamente.' : 'Encuesta rechazada correctamente.');
    }
}

