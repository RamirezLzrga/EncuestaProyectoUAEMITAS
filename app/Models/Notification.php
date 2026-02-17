<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Models\Survey;
use App\Models\User;

class Notification extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'notifications';

    protected $fillable = [
        'user_id',
        'role',
        'title',
        'message',
        'type',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function notifyExpiringSurveys($daysAhead = 3)
    {
        $now = now();
        $limitDate = $now->copy()->addDays($daysAhead)->endOfDay();

        $surveys = Survey::where('is_active', true)
            ->where('end_date', '>=', $now)
            ->where('end_date', '<=', $limitDate)
            ->get();

        foreach ($surveys as $survey) {
            $existing = self::where('type', 'survey_expiring')
                ->where('data->survey_id', (string) $survey->id)
                ->first();

            if ($existing) {
                continue;
            }

            $owner = $survey->user_id ? User::find($survey->user_id) : null;

            if ($owner) {
                self::create([
                    'user_id' => $owner->id,
                    'role' => $owner->role,
                    'title' => 'Encuesta próxima a vencer',
                    'message' => 'Tu encuesta "' . $survey->title . '" vence el ' . $survey->end_date->format('d/m/Y') . '.',
                    'type' => 'survey_expiring',
                    'data' => [
                        'survey_id' => (string) $survey->id,
                        'end_date' => $survey->end_date->toDateTimeString(),
                    ],
                ]);
            }

            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                self::create([
                    'user_id' => $admin->id,
                    'role' => 'admin',
                    'title' => 'Encuesta próxima a vencer',
                    'message' => 'La encuesta "' . $survey->title . '" vence el ' . $survey->end_date->format('d/m/Y') . '.',
                    'type' => 'survey_expiring_admin',
                    'data' => [
                        'survey_id' => (string) $survey->id,
                        'end_date' => $survey->end_date->toDateTimeString(),
                    ],
                ]);
            }
        }
    }
}
