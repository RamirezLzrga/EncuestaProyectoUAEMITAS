@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <div>
                <h1 class="page-title">Panel de Control Administrativo</h1>
                <p class="page-subtitle">
                    Vista general del sistema • Actualizado el
                    <span id="dashboard-updated-at"></span>
                </p>
            </div>
            <div class="page-actions">
                <a href="{{ route('activity-logs.export') }}" class="btn btn-secondary">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Exportar
                </a>
                <a href="{{ route('admin.reportes') }}" class="btn btn-gold">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Generar Reporte
                </a>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Total de Encuestas</div>
                <div class="stat-icon green">📋</div>
            </div>
            <div class="stat-value">{{ $totalSurveys }}</div>
            <div class="stat-change positive">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>{{ $totalSurveys > 0 ? '+'.number_format(($totalSurveys / max($totalSurveys, 1)) * 100, 0).'%' : '+0%' }} vs periodo anterior</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Respuestas Totales</div>
                <div class="stat-icon gold">📊</div>
            </div>
            <div class="stat-value">{{ $totalResponses }}</div>
            <div class="stat-change positive">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>Promedio {{ $avgResponses }} por encuesta</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Tasa de Completado</div>
                <div class="stat-icon blue">✓</div>
            </div>
            <div class="stat-value">{{ $completionRate }}%</div>
            <div class="stat-change positive">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>Completadas vs total de respuestas</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Usuarios Activos</div>
                <div class="stat-icon green">👥</div>
            </div>
            <div class="stat-value">{{ $activeUsers }}</div>
            <div class="stat-change positive">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>Usuarios con estado activo</span>
            </div>
        </div>
    </div>

    <div class="alert-card">
        <div class="alert-header">
            <div class="alert-icon">⚠️</div>
            <div class="alert-content">
                @if($pendingApprovals > 0)
                    <h4>{{ $pendingApprovals }} encuesta{{ $pendingApprovals === 1 ? '' : 's' }} pendiente{{ $pendingApprovals === 1 ? '' : 's' }} de aprobación</h4>
                    <p>Hay solicitudes de publicación esperando tu revisión. Revisa y aprueba para que los
                        editores puedan continuar.</p>
                @else
                    <h4>No hay encuestas pendientes de aprobación</h4>
                    <p>Las solicitudes de publicación están al día.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="content-row">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="card-icon">📈</div>
                    Actividad del Sistema
                </div>
                <div class="card-actions">
                    <button class="filter-chip">7D</button>
                    <button class="filter-chip active">30D</button>
                    <button class="filter-chip">90D</button>
                    <button class="filter-chip">1A</button>
                </div>
            </div>
            <div class="chart-container">
                @if($systemActivity['new_surveys'] > 0 || $systemActivity['new_responses'] > 0)
                    <div class="chart-placeholder-content">
                        <div class="chart-icon">📊</div>
                        <div style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">
                            Actividad en los {{ $systemActivity['period_label'] }}
                        </div>
                        <div style="font-size: 0.875rem; margin-bottom: 0.25rem;">
                            {{ $systemActivity['new_surveys'] }}
                            nueva{{ $systemActivity['new_surveys'] === 1 ? '' : 's' }}
                            encuesta{{ $systemActivity['new_surveys'] === 1 ? '' : 's' }}
                            y {{ $systemActivity['new_responses'] }}
                            respuesta{{ $systemActivity['new_responses'] === 1 ? '' : 's' }}
                            registrada{{ $systemActivity['new_responses'] === 1 ? '' : 's' }}.
                        </div>
                        @if($systemActivity['top_day'])
                            <div style="font-size: 0.8rem; color: var(--gray-500);">
                                Día con más respuestas: {{ $systemActivity['top_day']['label'] }}
                                ({{ $systemActivity['top_day']['responses'] }} respuestas)
                            </div>
                        @endif
                    </div>
                @else
                    <div class="chart-placeholder-content">
                        <div class="chart-icon">📊</div>
                        <div style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">
                            Sin actividad reciente
                        </div>
                        <div style="font-size: 0.875rem;">
                            No se registran nuevas encuestas ni respuestas en los últimos 30 días.
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="card-icon">🔔</div>
                    Actividad Reciente
                </div>
            </div>
            <div class="activity-list">
                @forelse($recentActivity as $activity)
                    <div class="activity-item">
                        <div class="activity-icon-wrapper {{ $activity['icon_class'] }}">{{ $activity['icon'] }}</div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $activity['title'] }}</div>
                            <div class="activity-description">
                                {{ $activity['description'] }}
                            </div>
                        </div>
                        <div class="activity-time">{{ $activity['time'] }}</div>
                    </div>
                @empty
                    <div class="activity-item">
                        <div class="activity-icon-wrapper survey">📋</div>
                        <div class="activity-content">
                            <div class="activity-title">Sin actividad reciente</div>
                            <div class="activity-description">
                                No se han registrado nuevas encuestas, usuarios o respuestas recientemente.
                            </div>
                        </div>
                        <div class="activity-time">—</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="card-icon">🏆</div>
                Editores Destacados del Mes
            </div>
            <button class="btn btn-secondary">Ver Todos</button>
        </div>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Encuestas</th>
                    <th>Respuestas</th>
                    <th>Última Actividad</th>
                </tr>
                </thead>
                <tbody>
                @forelse($topEditors as $editor)
                    @php
                        $user = $editor['user'];
                        $nameParts = explode(' ', trim($user->name));
                        $initials = '';
                        if (count($nameParts) > 0) {
                            $initials .= mb_substr($nameParts[0], 0, 1, 'UTF-8');
                        }
                        if (count($nameParts) > 1) {
                            $initials .= mb_substr($nameParts[1], 0, 1, 'UTF-8');
                        }
                    @endphp
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-cell-avatar">{{ $initials }}</div>
                                <div class="user-cell-info">
                                    <h4>{{ $user->name }}</h4>
                                    <p>{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'admin' : 'editor' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <div class="metric-value">{{ $editor['surveys_count'] }}</div>
                            <div class="metric-label">encuesta{{ $editor['surveys_count'] === 1 ? '' : 's' }}</div>
                        </td>
                        <td>
                            <div class="metric-value">{{ number_format($editor['responses_count']) }}</div>
                            <div class="metric-label">respuesta{{ $editor['responses_count'] === 1 ? '' : 's' }}</div>
                        </td>
                        <td style="color: var(--gray-500); font-size: 0.875rem;">
                            @if($editor['last_activity_at'])
                                {{ \Carbon\Carbon::parse($editor['last_activity_at'])->diffForHumans() }}
                            @else
                                Sin actividad reciente
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 1.5rem; color: var(--gray-400); font-size: 0.9rem;">
                            No hay editores con actividad en el periodo seleccionado.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var el = document.getElementById('dashboard-updated-at');
        if (!el) {
            return;
        }

        function updateDashboardTime() {
            var now = new Date();
            var day = String(now.getDate()).padStart(2, '0');
            var month = String(now.getMonth() + 1).padStart(2, '0');
            var year = now.getFullYear();
            var hours = String(now.getHours()).padStart(2, '0');
            var minutes = String(now.getMinutes()).padStart(2, '0');
            var seconds = String(now.getSeconds()).padStart(2, '0');
            el.textContent = day + '/' + month + '/' + year + ', ' + hours + ':' + minutes + ':' + seconds;
        }

        updateDashboardTime();
        setInterval(updateDashboardTime, 1000);
    });
</script>
@endpush
