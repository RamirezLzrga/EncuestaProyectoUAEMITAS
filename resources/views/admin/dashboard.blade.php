@extends('layouts.admin_softui')

@section('title', 'Dashboard')

@section('content')
    <div class="ph">
        <div class="ph-left">
            <div class="ph-label">Vista General</div>
            <div class="ph-title">Panel de Control</div>
            <div class="ph-sub">
                Bienvenido de vuelta, {{ strtok(Auth::user()->name ?? 'Usuario',' ') }} —
                <span id="dashboard-updated-at"></span>
            </div>
        </div>
        <div class="ph-actions">
            <a href="{{ route('activity-logs.export') }}" class="btn btn-neu">↓ Exportar</a>
            <a href="{{ route('admin.reportes') }}" class="btn btn-oro">⬡ Generar Reporte</a>
        </div>
    </div>

    <div class="dash-grid">
        <div class="kpi-row">
            <div class="kpi-card">
                <div class="kp-top">
                    <div class="kp-icon"><span>📋</span></div>
                    <span class="kp-change kp-up">↑ +100%</span>
                </div>
                <div class="kp-value">{{ $totalSurveys }}</div>
                <div class="kp-label">Encuestas</div>
                <div class="kp-desc">Activas este periodo</div>
                <div class="kpi-card-bg" style="background:var(--verde)"></div>
            </div>
            <div class="kpi-card">
                <div class="kp-top">
                    <div class="kp-icon"><span>📬</span></div>
                    <span class="kp-change kp-up">↑ {{ $avgResponses }}/enc</span>
                </div>
                <div class="kp-value">{{ $totalResponses }}</div>
                <div class="kp-label">Respuestas</div>
                <div class="kp-desc">Totales recibidas</div>
                <div class="kpi-card-bg" style="background:var(--oro)"></div>
            </div>
            <div class="kpi-card">
                <div class="kp-top">
                    <div class="kp-icon"><span>✅</span></div>
                    <span class="kp-change kp-flat">—</span>
                </div>
                <div class="kp-value">{{ $completionRate }}%</div>
                <div class="kp-label">Completado</div>
                <div class="kp-desc">Tasa de finalización</div>
                <div class="kpi-card-bg" style="background:var(--text-muted)"></div>
            </div>
            <div class="kpi-card">
                <div class="kp-top">
                    <div class="kp-icon"><span>👤</span></div>
                    <span class="kp-change kp-up">↑ Activos</span>
                </div>
                <div class="kp-value">{{ $activeUsers }}</div>
                <div class="kp-label">Usuarios</div>
                <div class="kp-desc">Con acceso activo</div>
                <div class="kpi-card-bg" style="background:var(--verde)"></div>
            </div>
        </div>

        <div class="welcome-band">
            <div class="wb-circles"></div>
            <div class="wb-circles2"></div>
            <div>
                <div class="wb-tag">UAEMex · SIEI</div>
                <div class="wb-title">¡Bienvenido, {{ strtok(Auth::user()->name ?? 'Usuario',' ') }}! 👋</div>
                <div class="wb-sub">
                    @if($pendingApprovals > 0)
                        Tienes {{ $pendingApprovals }} encuesta{{ $pendingApprovals===1?'':'s' }} pendiente{{ $pendingApprovals===1?'':'s' }} de aprobación.
                    @else
                        No hay encuestas pendientes de aprobación.
                    @endif
                </div>
                <div style="margin-top:16px;display:flex;gap:10px">
                    <a href="{{ route('admin.aprobaciones') }}" class="btn btn-oro btn-sm">Ver aprobaciones →</a>
                </div>
            </div>
            <div class="wb-date">
                <div class="wb-date-day">{{ now()->format('d') }}</div>
                <div class="wb-date-rest">{{ strtoupper(now()->format('M')) }} / {{ now()->format('Y') }}<br>{{ now()->format('h:i A') }}</div>
            </div>
        </div>

        <div class="quick-actions">
            <div class="qa-title">Acciones Rápidas</div>
            <div class="qa-grid">
                <a class="qa-item" href="{{ route('surveys.create') }}"><div class="qa-emoji">📝</div><div class="qa-label">Nueva Encuesta</div></a>
                <a class="qa-item" href="{{ route('users.create') }}"><div class="qa-emoji">👥</div><div class="qa-label">Añadir Usuario</div></a>
                <a class="qa-item" href="{{ route('statistics.index') }}"><div class="qa-emoji">📊</div><div class="qa-label">Ver Estadísticas</div></a>
                <a class="qa-item" href="{{ route('activity-logs.index') }}"><div class="qa-emoji">📜</div><div class="qa-label">Bitácora</div></a>
            </div>
        </div>

        <div class="chart-card">
            <div class="cc-header">
                <div>
                    <div class="cc-title">Respuestas por Período</div>
                    <div class="cc-sub">Actividad acumulada del sistema</div>
                </div>
                <div class="tab-group">
                    <div class="tg-tab">7D</div>
                    <div class="tg-tab active">30D</div>
                    <div class="tg-tab">90D</div>
                    <div class="tg-tab">1A</div>
                </div>
            </div>
            <div class="chart-body">
                <div class="cb-bar-wrap"><div class="cb-bar verde" style="height:25%"></div><span class="cb-month">Ene</span></div>
                <div class="cb-bar-wrap"><div class="cb-bar oro"   style="height:48%"></div><span class="cb-month">Feb</span></div>
                <div class="cb-bar-wrap"><div class="cb-bar verde" style="height:35%"></div><span class="cb-month">Mar</span></div>
                <div class="cb-bar-wrap"><div class="cb-bar oro"   style="height:70%"></div><span class="cb-month">Abr</span></div>
                <div class="cb-bar-wrap"><div class="cb-bar verde" style="height:52%"></div><span class="cb-month">May</span></div>
                <div class="cb-bar-wrap"><div class="cb-bar oro"   style="height:88%"></div><span class="cb-month">Jun</span></div>
            </div>
        </div>

        <div class="donut-card">
            <div class="cc-title">Estado de Encuestas</div>
            <div class="cc-sub" style="font-size:12px;color:var(--text-muted);margin-top:2px">Distribución actual</div>
            <div class="donut-wrap">
                <div class="donut-svg-wrap">
                    <svg class="donut-svg" viewBox="0 0 42 42">
                        <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#dde3d6" stroke-width="5"/>
                        <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="var(--verde)" stroke-width="5" stroke-dasharray="55 45" stroke-dashoffset="0"/>
                        <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="var(--oro-bright)" stroke-width="5" stroke-dasharray="30 70" stroke-dashoffset="-55"/>
                        <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="var(--text-light)" stroke-width="5" stroke-dasharray="15 85" stroke-dashoffset="-85"/>
                    </svg>
                    <div class="donut-center">
                        <div class="donut-pct">{{ $totalSurveys }}</div>
                        <div class="donut-pct-label">Total</div>
                    </div>
                </div>
                <div class="donut-legend">
                    <div class="dl-row"><div class="dl-dot" style="background:var(--verde)"></div>Activas<div class="dl-val">—</div></div>
                    <div class="dl-row"><div class="dl-dot" style="background:var(--oro-bright)"></div>Pendientes<div class="dl-val">—</div></div>
                    <div class="dl-row"><div class="dl-dot" style="background:var(--text-light)"></div>Cerradas<div class="dl-val">—</div></div>
                </div>
            </div>
        </div>

        <div class="progress-card">
            <div class="cc-title">Participación por Encuesta</div>
            <div class="cc-sub" style="font-size:12px;color:var(--text-muted);margin-top:2px">Respuestas vs. límite</div>
            <div class="pw-items">
                <div class="pw-item">
                    <div class="pw-item-top"><span class="pw-name">—</span><span class="pw-pct">—</span></div>
                    <div class="pw-track"><div class="pw-fill verde" style="width:10%"></div></div>
                </div>
                <div class="pw-item">
                    <div class="pw-item-top"><span class="pw-name">—</span><span class="pw-pct">—</span></div>
                    <div class="pw-track"><div class="pw-fill oro" style="width:30%"></div></div>
                </div>
            </div>
        </div>

        <div class="heatmap-card">
            <div class="cc-title">Mapa de Actividad</div>
            <div class="cc-sub" style="font-size:12px;color:var(--text-muted);margin-top:2px">Acciones por día</div>
            <div class="hm-grid">
                <div class="hm-day-label">L</div><div class="hm-day-label">M</div><div class="hm-day-label">X</div><div class="hm-day-label">J</div><div class="hm-day-label">V</div><div class="hm-day-label">S</div><div class="hm-day-label">D</div>
                <div class="hm-cell hm-1"></div><div class="hm-cell hm-0"></div><div class="hm-cell hm-2"></div><div class="hm-cell hm-1"></div><div class="hm-cell hm-3"></div><div class="hm-cell hm-0"></div><div class="hm-cell hm-0"></div>
                <div class="hm-cell hm-2"></div><div class="hm-cell hm-3"></div><div class="hm-cell hm-1"></div><div class="hm-cell hm-4"></div><div class="hm-cell hm-2"></div><div class="hm-cell hm-0"></div><div class="hm-cell hm-0"></div>
            </div>
        </div>

        <div class="table-card">
            <div class="cc-title">Encuestas Recientes</div>
            <div class="rc-list">
                <div class="rc-item">
                    <div class="rc-top"><span class="rc-name">—</span><span class="badge-neu bn-green">● Activa</span></div>
                    <div class="rc-bar-wrap"><div class="rc-mini-bar"><div class="rc-mini-fill" style="width:10%"></div></div><span class="rc-num">1/100 resp.</span></div>
                </div>
                <div class="rc-item">
                    <div class="rc-top"><span class="rc-name">—</span><span class="badge-neu bn-gold">○ Pendiente</span></div>
                    <div class="rc-bar-wrap"><div class="rc-mini-bar"><div class="rc-mini-fill" style="width:0%"></div></div><span class="rc-num">0/100 resp.</span></div>
                </div>
            </div>
        </div>

        <div class="timeline-card">
            <div class="cc-title">Actividad Reciente</div>
            <div class="tl-list">
                <div class="tl-line"></div>
                @forelse($recentActivity as $activity)
                    <div class="tl-item"><div class="tl-dot">{{ $activity['icon'] }}</div><div class="tl-content"><div class="tl-action">{{ $activity['title'] }}</div><div class="tl-meta">{{ $activity['description'] }} · {{ $activity['time'] }}</div></div></div>
                @empty
                    <div class="tl-item"><div class="tl-dot">📋</div><div class="tl-content"><div class="tl-action">Sin actividad reciente</div><div class="tl-meta">—</div></div></div>
                @endforelse
            </div>
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
