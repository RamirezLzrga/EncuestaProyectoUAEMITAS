@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <div>
                <h1 class="page-title">Panel de Control Administrativo</h1>
                <p class="page-subtitle">
                    Vista general del sistema • Actualizado el
                    {{ \Carbon\Carbon::now()->format('d/m/Y, H:i') }}
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
            <div class="stat-value">87.3%</div>
            <div class="stat-change positive">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>+3.2% vs mes anterior</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-label">Usuarios Activos</div>
                <div class="stat-icon green">👥</div>
            </div>
            <div class="stat-value">42</div>
            <div class="stat-change positive">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span>+5 nuevos este mes</span>
            </div>
        </div>
    </div>

    <div class="alert-card">
        <div class="alert-header">
            <div class="alert-icon">⚠️</div>
            <div class="alert-content">
                <h4>3 encuestas pendientes de aprobación</h4>
                <p>Hay solicitudes de publicación esperando tu revisión. Revisa y aprueba para que los
                    editores puedan continuar.</p>
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
                <div class="chart-placeholder-content">
                    <div class="chart-icon">📊</div>
                    <div style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">
                        Gráfico de Líneas Temporal
                    </div>
                    <div style="font-size: 0.875rem;">Respuestas y encuestas creadas por día</div>
                </div>
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
                <div class="activity-item">
                    <div class="activity-icon-wrapper auth">🔐</div>
                    <div class="activity-content">
                        <div class="activity-title">Inicio de sesión exitoso</div>
                        <div class="activity-description">
                            {{ Auth::user()->name }} • IP: 127.0.0.1
                        </div>
                    </div>
                    <div class="activity-time">Hace 5 min</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon-wrapper survey">📋</div>
                    <div class="activity-content">
                        <div class="activity-title">Nueva encuesta creada</div>
                        <div class="activity-description">
                            Ejemplo de actividad reciente en el sistema
                        </div>
                    </div>
                    <div class="activity-time">Hace 1 hora</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon-wrapper user">👤</div>
                    <div class="activity-content">
                        <div class="activity-title">Nuevo usuario registrado</div>
                        <div class="activity-description">Usuario de ejemplo • Rol: Editor</div>
                    </div>
                    <div class="activity-time">Hace 2 horas</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon-wrapper approval">✅</div>
                    <div class="activity-content">
                        <div class="activity-title">Encuesta aprobada</div>
                        <div class="activity-description">
                            Encuesta institucional aprobada correctamente
                        </div>
                    </div>
                    <div class="activity-time">Hace 3 horas</div>
                </div>
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
                    <th>Tasa de Completado</th>
                    <th>Última Actividad</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="user-cell">
                            <div class="user-cell-avatar">JR</div>
                            <div class="user-cell-info">
                                <h4>Juan Ramírez Morelos</h4>
                                <p>car@gmail.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge editor">Editor</span></td>
                    <td>
                        <div class="metric-value">28</div>
                        <div class="metric-label">encuestas</div>
                    </td>
                    <td>
                        <div class="metric-value">3,847</div>
                        <div class="metric-label">respuestas</div>
                    </td>
                    <td>
                        <div class="progress-wrapper">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 92%"></div>
                            </div>
                            <div class="progress-percentage">92%</div>
                        </div>
                    </td>
                    <td style="color: var(--gray-500); font-size: 0.875rem;">Hace 2 horas</td>
                </tr>

                <tr>
                    <td>
                        <div class="user-cell">
                            <div class="user-cell-avatar">AC</div>
                            <div class="user-cell-info">
                                <h4>Alexis Crisantos Arellano</h4>
                                <p>rich@gmail.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge admin">Administrador</span></td>
                    <td>
                        <div class="metric-value">45</div>
                        <div class="metric-label">encuestas</div>
                    </td>
                    <td>
                        <div class="metric-value">5,291</div>
                        <div class="metric-label">respuestas</div>
                    </td>
                    <td>
                        <div class="progress-wrapper">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 88%"></div>
                            </div>
                            <div class="progress-percentage">88%</div>
                        </div>
                    </td>
                    <td style="color: var(--gray-500); font-size: 0.875rem;">Hace 3 horas</td>
                </tr>

                <tr>
                    <td>
                        <div class="user-cell">
                            <div class="user-cell-avatar">MG</div>
                            <div class="user-cell-info">
                                <h4>María González</h4>
                                <p>maria@example.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge editor">Editor</span></td>
                    <td>
                        <div class="metric-value">19</div>
                        <div class="metric-label">encuestas</div>
                    </td>
                    <td>
                        <div class="metric-value">1,745</div>
                        <div class="metric-label">respuestas</div>
                    </td>
                    <td>
                        <div class="progress-wrapper">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 85%"></div>
                            </div>
                            <div class="progress-percentage">85%</div>
                        </div>
                    </td>
                    <td style="color: var(--gray-500); font-size: 0.875rem;">Hace 1 día</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

