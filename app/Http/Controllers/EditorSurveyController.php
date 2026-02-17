<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditorSurveyController extends Controller
{
    public function builderNew()
    {
        $survey = new Survey([
            'title' => '',
            'description' => '',
            'year' => date('Y'),
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'settings' => [],
            'questions' => [],
        ]);

        return view('editor.encuestas.builder', [
            'survey' => $survey,
            'mode' => 'create',
        ]);
    }

    public function builderEdit(Survey $survey)
    {
        if ($survey->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('editor.encuestas.builder', [
            'survey' => $survey,
            'mode' => 'edit',
        ]);
    }

    public function builderStore(Request $request)
    {
        $survey = $this->saveSurveyFromBuilder($request, new Survey());

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'role' => 'admin',
                'title' => 'Nueva encuesta creada en editor',
                'message' => Auth::user()->name . ' creó la encuesta "' . $survey->title . '" desde el editor.',
                'type' => 'editor_survey_created',
                'data' => [
                    'survey_id' => (string) $survey->id,
                    'creator_id' => (string) Auth::id(),
                ],
            ]);
        }

        return redirect()->route('editor.encuestas.configuracion', $survey)->with('success', 'Encuesta creada. Configura los detalles generales.');
    }

    public function builderUpdate(Request $request, Survey $survey)
    {
        if ($survey->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $this->saveSurveyFromBuilder($request, $survey);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'role' => 'admin',
                'title' => 'Encuesta modificada en editor',
                'message' => Auth::user()->name . ' modificó la encuesta "' . $survey->title . '" desde el editor.',
                'type' => 'editor_survey_updated',
                'data' => [
                    'survey_id' => (string) $survey->id,
                    'editor_id' => (string) Auth::id(),
                ],
            ]);
        }

        return redirect()->route('editor.encuestas.configuracion', $survey)->with('success', 'Encuesta actualizada.');
    }

    protected function saveSurveyFromBuilder(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'settings' => 'array',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|string',
            'questions.*.options' => 'nullable|array',
            'questions.*.required' => 'nullable',
        ]);

        $questions = array_values($validated['questions']);
        foreach ($questions as &$question) {
            $question['required'] = isset($question['required']);
        }
        $validated['questions'] = $questions;

        $defaultSettings = [
            'anonymous' => false,
            'collect_names' => false,
            'collect_emails' => false,
            'allow_multiple' => false,
        ];
        $validated['settings'] = array_merge($defaultSettings, $request->input('settings', []));
        foreach ($validated['settings'] as $key => $value) {
            $validated['settings'][$key] = (bool) $value;
        }

        $survey->fill($validated);
        if (!$survey->exists) {
            $survey->user_id = Auth::id();
        }
        $survey->is_active = false;
        $survey->approval_status = 'pending';
        $survey->save();

        return $survey;
    }

    public function configuracion(Survey $survey)
    {
        if ($survey->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('editor.encuestas.configuracion', [
            'survey' => $survey,
        ]);
    }

    public function configuracionUpdate(Request $request, Survey $survey)
    {
        if ($survey->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_responses' => 'nullable|integer|min:1',
            'theme' => 'nullable|string|max:50',
            'logo_url' => 'nullable|string|max:255',
            'thank_you_page' => 'nullable|string',
            'public_link' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:100',
            'one_response_per_ip' => 'nullable|boolean',
            'allow_edit_response' => 'nullable|boolean',
            'show_progress_bar' => 'nullable|boolean',
        ]);

        $settings = $survey->settings ?? [];
        $settings['max_responses'] = $data['max_responses'] ?? null;
        $settings['theme'] = $data['theme'] ?? null;
        $settings['logo_url'] = $data['logo_url'] ?? null;
        $settings['thank_you_page'] = $data['thank_you_page'] ?? null;
        $settings['public_link'] = $data['public_link'] ?? route('surveys.public', $survey->id);
        $settings['password'] = $data['password'] ?? null;
        $settings['one_response_per_ip'] = $request->boolean('one_response_per_ip');
        $settings['allow_edit_response'] = $request->boolean('allow_edit_response');
        $settings['show_progress_bar'] = $request->boolean('show_progress_bar');

        $survey->title = $data['title'];
        $survey->description = $data['description'] ?? null;
        $survey->start_date = $data['start_date'];
        $survey->end_date = $data['end_date'];
        $survey->settings = $settings;
        $survey->save();

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'role' => 'admin',
                'title' => 'Configuración de encuesta actualizada',
                'message' => Auth::user()->name . ' actualizó la configuración de "' . $survey->title . '".',
                'type' => 'editor_survey_config_updated',
                'data' => [
                    'survey_id' => (string) $survey->id,
                    'editor_id' => (string) Auth::id(),
                ],
            ]);
        }

        return redirect()->route('editor.encuestas.respuestas', $survey)->with('success', 'Configuración guardada.');
    }

    public function respuestas(Survey $survey)
    {
        if ($survey->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $responses = SurveyResponse::where('survey_id', $survey->id)->orderBy('created_at', 'desc')->get();
        $totalResponses = $responses->count();
        $completed = $responses->where('is_complete', true)->count();
        $completionRate = $totalResponses > 0 ? round(($completed / $totalResponses) * 100, 1) : 0;
        $avgTimeSeconds = $totalResponses > 0 ? round($responses->avg('completion_time_seconds')) : null;

        return view('editor.encuestas.respuestas', [
            'survey' => $survey,
            'responses' => $responses,
            'totalResponses' => $totalResponses,
            'completionRate' => $completionRate,
            'avgTimeSeconds' => $avgTimeSeconds,
        ]);
    }

    public function compartir(Survey $survey)
    {
        if ($survey->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $publicLink = route('surveys.public', $survey->id);

        return view('editor.encuestas.compartir', [
            'survey' => $survey,
            'publicLink' => $publicLink,
        ]);
    }
}
