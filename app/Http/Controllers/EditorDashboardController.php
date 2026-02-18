<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Support\Facades\Auth;

class EditorDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $surveys = Survey::where('user_id', $userId)->get();
        $totalSurveys = $surveys->count();
        $activeSurveys = $surveys->where('is_active', true)->count();
        $inactiveSurveys = $totalSurveys - $activeSurveys;

        $totalResponses = 0;
        foreach ($surveys as $survey) {
            $totalResponses += $survey->responses()->count();
        }

        $avgResponses = $totalSurveys > 0 ? round($totalResponses / $totalSurveys, 1) : 0;
        $completionRate = $totalSurveys > 0 ? round(($activeSurveys / max($totalSurveys, 1)) * 100) : 0;

        $recentSurveys = Survey::where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        return view('editor.dashboard', compact(
            'totalSurveys',
            'activeSurveys',
            'inactiveSurveys',
            'totalResponses',
            'avgResponses',
            'completionRate',
            'recentSurveys'
        ));
    }
}

