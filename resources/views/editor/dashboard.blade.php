@extends('layouts.editor')

@section('title', 'Mi Espacio')

@section('content')
<div class="welcome-section">
    <div class="welcome-content">
        <h2 class="greeting">¡Bienvenido de nuevo, {{ Auth::user()->name }}!</h2>
        <p class="greeting-subtitle">Aquí está el resumen de tu actividad reciente</p>
        <div class="quick-stats">
            <div class="quick-stat">
                <div class="quick-stat-value">{{ $totalSurveys }}</div>
                <div class="quick-stat-label">Encuestas creadas</div>
            </div>
            <div class="quick-stat">
                <div class="quick-stat-value">{{ $totalResponses }}</div>
                <div class="quick-stat-label">Respuestas totales</div>
            </div>
            <div class="quick-stat">
                <div class="quick-stat-value">{{ $completionRate }}%</div>
                <div class="quick-stat-label">Tasa de completado</div>
            </div>
            <div class="quick-stat">
                <div class="quick-stat-value">{{ $activeSurveys }}</div>
                <div class="quick-stat-label">Activas ahora</div>
            </div>
        </div>
    </div>
    </div>

<h2 class="section-title">Acciones rápidas</h2>
<div class="quick-actions">
    <a href="{{ route('editor.encuestas.nueva') }}" class="action-card">
        <div class="action-icon primary">➕</div>
        <div class="action-content">
            <h3>Nueva encuesta</h3>
            <p>Crea una encuesta desde cero con todas las herramientas disponibles</p>
        </div>
    </a>
    <a href="{{ route('surveys.index') }}" class="action-card">
        <div class="action-icon gold">📋</div>
        <div class="action-content">
            <h3>Mis encuestas</h3>
            <p>Revisa el listado completo de tus encuestas creadas</p>
        </div>
    </a>
    <a href="{{ route('statistics.index') }}" class="action-card">
        <div class="action-icon blue">📊</div>
        <div class="action-content">
            <h3>Ver estadísticas</h3>
            <p>Analiza los resultados y genera reportes detallados</p>
        </div>
    </a>
    </div>

<div class="content-grid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mis encuestas recientes</h3>
            <a href="{{ route('surveys.index') }}" class="view-all-link">
                Ver todas
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="survey-list">
            @forelse($recentSurveys as $survey)
                @php
                    $responsesCount = $survey->responses()->count();
                    $statusClass = $survey->is_active ? 'active' : 'draft';
                    $statusText = $survey->is_active ? 'Activa' : 'Borrador';
                @endphp
                <a href="{{ route('editor.encuestas.editar', $survey) }}" class="survey-item">
                    <div class="survey-header">
                        <div>
                            <div class="survey-title">{{ $survey->title ?: 'Encuesta sin título' }}</div>
                            <div class="survey-meta">
                                <span>
                                    📅 Creada:
                                    {{ optional($survey->created_at)->format('d M Y') }}
                                </span>
                                <span>
                                    🔗
                                    {{ $survey->is_public ? 'Pública' : 'Privada' }}
                                </span>
                            </div>
                        </div>
                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                    </div>
                    <div class="survey-stats-row">
                        <div class="survey-stat">
                            <div class="survey-stat-value">{{ $responsesCount }}</div>
                            <div class="survey-stat-label">Respuestas</div>
                        </div>
                        <div class="survey-stat">
                            <div class="survey-stat-value">
                                @if($responsesCount > 0)
                                    100%
                                @else
                                    --
                                @endif
                            </div>
                            <div class="survey-stat-label">Completado</div>
                        </div>
                        <div class="survey-stat">
                            <div class="survey-stat-value">--</div>
                            <div class="survey-stat-label">Tiempo prom.</div>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-sm text-gray-500">Aún no tienes encuestas recientes registradas.</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Actividad reciente</h3>
        </div>

        <div class="activity-item">
            <div class="activity-icon-box green">📊</div>
            <div class="activity-info">
                <div class="activity-title">{{ $totalResponses }} respuestas registradas</div>
                <div class="activity-description">En tus encuestas activas</div>
            </div>
            <div class="activity-time">Últimos días</div>
        </div>

        <div class="activity-item">
            <div class="activity-icon-box gold">✅</div>
            <div class="activity-info">
                <div class="activity-title">{{ $activeSurveys }} encuestas activas</div>
                <div class="activity-description">Disponibles para recibir respuestas</div>
            </div>
            <div class="activity-time">Ahora</div>
        </div>

        <div class="activity-item">
            <div class="activity-icon-box blue">📝</div>
            <div class="activity-info">
                <div class="activity-title">{{ $inactiveSurveys }} encuestas en borrador o cerradas</div>
                <div class="activity-description">Listas para ajustar o reactivar</div>
            </div>
            <div class="activity-time">Reciente</div>
        </div>
    </div>
</div>

<div class="card" style="margin-bottom: 2rem;">
    <div class="card-header">
        <h3 class="card-title">Rendimiento de mis encuestas</h3>
        <div style="display: flex; gap: 0.5rem;">
            <button class="btn btn-outline">7D</button>
            <button class="btn btn-primary">30D</button>
            <button class="btn btn-outline">90D</button>
        </div>
    </div>
    <div class="chart-area">
        <div class="chart-placeholder">
            <div class="chart-placeholder-icon">📈</div>
            <div style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">Gráfico de respuestas</div>
            <div style="font-size: 0.875rem;">Últimos 30 días • Placeholder visual</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Plantillas recomendadas</h3>
        <a href="{{ route('surveys.index') }}" class="view-all-link">
            Ver todas
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>

    <div class="templates-grid">
        <div class="template-card">
            <div class="template-icon-box">😊</div>
            <div class="template-title">Satisfacción del cliente</div>
            <div class="template-description">Mide la experiencia de tus usuarios con tu servicio o producto.</div>
            <div class="template-uses">Referencia visual • UAEMex</div>
        </div>

        <div class="template-card">
            <div class="template-icon-box">💼</div>
            <div class="template-title">Evaluación de desempeño</div>
            <div class="template-description">Evalúa el rendimiento y desarrollo de tu equipo de trabajo.</div>
            <div class="template-uses">Referencia visual • UAEMex</div>
        </div>

        <div class="template-card">
            <div class="template-icon-box">🎯</div>
            <div class="template-title">Feedback de evento</div>
            <div class="template-description">Recopila opiniones y sugerencias después de eventos académicos.</div>
            <div class="template-uses">Referencia visual • UAEMex</div>
        </div>

        <div class="template-card">
            <div class="template-icon-box">📚</div>
            <div class="template-title">Evaluación de curso</div>
            <div class="template-description">Evalúa la calidad de cursos, capacitaciones y programas educativos.</div>
            <div class="template-uses">Referencia visual • UAEMex</div>
        </div>
    </div>
</div>
@endsection

