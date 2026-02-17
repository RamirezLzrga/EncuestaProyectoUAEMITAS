@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  :root {
    --verde:        #2D6A2D;
    --verde-oscuro: #1a4a1a;
    --verde-claro:  #4a8f4a;
    --verde-menta:  #d4ead4;
    --oro:          #C9A84C;
    --oro-claro:    #e8c96b;
    --crema:        #F9F6EF;
    --blanco:       #ffffff;
    --gris-texto:   #2a2a2a;
    --gris-suave:   #6b6b6b;
    --borde:        rgba(45,106,45,0.15);
  }

  .dashboard-wrap {
    font-family: 'DM Sans', sans-serif;
    color: var(--gris-texto);
  }

  .dash-header {
    background: var(--blanco);
    border-radius: 20px;
    border: 1px solid var(--borde);
    padding: 28px 32px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    box-shadow: 0 2px 16px rgba(45,106,45,0.06);
    position: relative;
    overflow: hidden;
  }

  @media (min-width: 768px) {
    .dash-header { flex-direction: row; justify-content: space-between; align-items: center; }
  }

  .dash-header::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 180px; height: 3px;
    background: linear-gradient(90deg, var(--oro), var(--oro-claro), transparent);
    border-radius: 0 2px 2px 0;
  }

  .dash-eyebrow {
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--verde-claro);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .dash-eyebrow::before {
    content: '';
    display: block;
    width: 20px; height: 2px;
    background: var(--oro);
    border-radius: 1px;
  }

  .dash-title {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    font-weight: 900;
    color: var(--verde-oscuro);
    line-height: 1.1;
    margin-bottom: 4px;
  }

  .dash-subtitle {
    font-size: 13px;
    color: var(--gris-suave);
    font-weight: 300;
  }
  .dash-subtitle strong {
    font-weight: 600;
    color: var(--gris-texto);
  }

  .btn-nueva-encuesta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 13px 26px;
    background: linear-gradient(135deg, var(--verde-oscuro) 0%, var(--verde) 100%);
    color: var(--blanco);
    border: none;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    box-shadow: 0 6px 22px rgba(45,106,45,0.38);
    transition: all 0.25s ease;
    white-space: nowrap;
    flex-shrink: 0;
  }
  .btn-nueva-encuesta:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(45,106,45,0.50);
  }

  .stats-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    margin-top: 24px;
  }
  @media (min-width: 768px) {
    .stats-grid { grid-template-columns: repeat(3, 1fr); }
  }

  .stat-card {
    background: var(--blanco);
    border-radius: 20px;
    border: 1px solid var(--borde);
    padding: 28px 28px 24px;
    position: relative;
    overflow: hidden;
    transition: all 0.28s ease;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
  }
  .stat-card::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
    border-radius: 0 0 20px 20px;
  }
  .stat-card:hover {
    box-shadow: 0 12px 36px rgba(45,106,45,0.10);
    transform: translateY(-3px);
  }
  .stat-card:hover::after { transform: scaleX(1); }

  .stat-card.card-orange::after { background: linear-gradient(90deg, #f97316, #fb923c); }
  .stat-card.card-blue::after   { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
  .stat-card.card-verde::after  { background: linear-gradient(90deg, var(--verde-oscuro), var(--verde-claro)); }

  .stat-icon-wrap {
    width: 46px; height: 46px;
    border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 20px;
    font-size: 18px;
  }
  .icon-orange { background: #fff4ed; color: #f97316; }
  .icon-blue   { background: #eff6ff; color: #3b82f6; }
  .icon-pink   { background: #fdf2f8; color: #ec4899; }

  .stat-number {
    font-family: 'Playfair Display', serif;
    font-size: 44px;
    font-weight: 900;
    color: var(--gris-texto);
    line-height: 1;
    margin-bottom: 6px;
  }

  .stat-label {
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--gris-suave);
    margin-bottom: 16px;
  }

  .stat-badges {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
  }

  .badge {
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid;
    letter-spacing: 0.08em;
  }
  .badge-green { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
  .badge-red   { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }

  .stat-meta {
    font-size: 12px;
    color: #aaa;
    font-weight: 300;
  }
  .stat-meta strong { color: var(--gris-suave); font-weight: 500; }

  .progress-wrap { margin-top: 16px; }
  .progress-track {
    width: 100%;
    height: 6px;
    background: #f0f0f0;
    border-radius: 99px;
    overflow: hidden;
  }
  .progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--verde-oscuro), var(--verde-claro));
    border-radius: 99px;
    transition: width 1s cubic-bezier(0.22,1,0.36,1);
  }
  .progress-label {
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    color: #bbb;
    text-align: right;
    margin-top: 6px;
    letter-spacing: 0.08em;
  }

  .charts-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    margin-top: 24px;
  }
  @media (min-width: 1024px) {
    .charts-grid { grid-template-columns: repeat(2, 1fr); }
  }

  .chart-card {
    background: var(--blanco);
    border-radius: 20px;
    border: 1px solid var(--borde);
    padding: 28px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
  }

  .chart-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
  }

  .chart-title {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 700;
    color: var(--verde-oscuro);
  }

  .chart-eyebrow {
    font-family: 'DM Mono', monospace;
    font-size: 9px;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--verde-claro);
    margin-bottom: 4px;
  }

  .chart-area {
    height: 240px;
    position: relative;
  }

  .chart-area-donut {
    height: 240px;
    position: relative;
    display: flex;
    justify-content: center;
  }

  .donut-legend {
    display: flex;
    justify-content: center;
    gap: 24px;
    margin-top: 16px;
  }
  .legend-item {
    display: flex;
    align-items: center;
    gap: 7px;
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--gris-suave);
    font-weight: 500;
  }
  .legend-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
  }

  .recent-section {
    background: var(--blanco);
    border-radius: 20px;
    border: 1px solid var(--borde);
    padding: 28px;
    margin-top: 24px;
    margin-bottom: 32px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    position: relative;
    overflow: hidden;
  }
  .recent-section::before {
    content: '';
    position: absolute;
    top: 0; right: 0;
    width: 120px; height: 3px;
    background: linear-gradient(270deg, var(--oro), transparent);
  }

  .recent-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
  }

  .recent-title {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    font-weight: 700;
    color: var(--verde-oscuro);
  }

  .surveys-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 14px;
  }
  @media (min-width: 768px) {
    .surveys-grid { grid-template-columns: repeat(2, 1fr); }
  }

  .survey-item {
    border: 1.5px solid rgba(45,106,45,0.12);
    border-radius: 14px;
    padding: 18px 20px;
    position: relative;
    cursor: pointer;
    transition: all 0.25s ease;
    overflow: hidden;
  }
  .survey-item::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, var(--verde-oscuro), var(--verde-claro));
    opacity: 0;
    transition: opacity 0.25s;
    border-radius: 14px 0 0 14px;
  }
  .survey-item:hover {
    border-color: rgba(45,106,45,0.35);
    box-shadow: 0 6px 20px rgba(45,106,45,0.09);
    transform: translateY(-2px);
  }
  .survey-item:hover::before { opacity: 1; }

  .survey-item-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
  }

  .survey-name {
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
    color: var(--gris-texto);
    line-height: 1.3;
    transition: color 0.2s;
  }
  .survey-item:hover .survey-name { color: var(--verde-oscuro); }

  .survey-desc {
    font-size: 12px;
    color: #aaa;
    margin-top: 4px;
    font-weight: 300;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 80%;
  }

  .status-pill {
    font-family: 'DM Mono', monospace;
    font-size: 9px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 100px;
    font-weight: 500;
    white-space: nowrap;
    flex-shrink: 0;
  }
  .pill-active   { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
  .pill-inactive { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

  .survey-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 14px;
  }

  .meta-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-family: 'DM Mono', monospace;
    font-size: 10px;
    padding: 4px 10px;
    border-radius: 7px;
    color: var(--gris-suave);
    background: #f5f5f5;
    letter-spacing: 0.06em;
  }
  .meta-chip.chip-anon {
    background: #eff6ff;
    color: #2563eb;
  }
  .meta-chip.chip-count {
    background: var(--crema);
    color: var(--verde-oscuro);
    margin-left: auto;
    font-weight: 600;
    border: 1px solid var(--borde);
  }

  .empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 48px 20px;
  }
  .empty-icon {
    width: 56px; height: 56px;
    background: var(--crema);
    border: 1px solid var(--borde);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    margin: 0 auto 14px;
  }
  .empty-text {
    font-size: 14px;
    color: #bbb;
    font-weight: 300;
  }
</style>
@endpush

@section('content')
<div class="dashboard-wrap">
  <div class="dash-header">
    <div>
      <div class="dash-eyebrow">SIEI UAEMex</div>
      <h2 class="dash-title">Dashboard</h2>
      <p class="dash-subtitle">
        Resumen general •
        <strong>{{ $activeSurveys }} activas, {{ $inactiveSurveys }} inactivas</strong>
      </p>
    </div>
    <a href="{{ route('surveys.create') }}" class="btn-nueva-encuesta">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
      </svg>
      Nueva Encuesta
    </a>
  </div>

  <div class="stats-grid">
    <div class="stat-card card-orange">
      <div class="stat-icon-wrap icon-orange">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
          <line x1="16" y1="13" x2="8" y2="13"/>
          <line x1="16" y1="17" x2="8" y2="17"/>
          <polyline points="10 9 9 9 8 9"/>
        </svg>
      </div>
      <div class="stat-number">{{ $totalSurveys }}</div>
      <div class="stat-label">Total Encuestas</div>
      <div class="stat-badges">
        <span class="badge badge-green">{{ $activeSurveys }} activas</span>
        <span class="badge badge-red">{{ $inactiveSurveys }} inactivas</span>
      </div>
    </div>

    <div class="stat-card card-blue">
      <div class="stat-icon-wrap icon-blue">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="20" x2="18" y2="10"/>
          <line x1="12" y1="20" x2="12" y2="4"/>
          <line x1="6" y1="20" x2="6" y2="14"/>
        </svg>
      </div>
      <div class="stat-number">{{ $totalResponses }}</div>
      <div class="stat-label">Respuestas Recibidas</div>
      <p class="stat-meta">Promedio: <strong>{{ $avgResponses }}</strong> por encuesta</p>
    </div>

    <div class="stat-card card-verde">
      <div class="stat-icon-wrap icon-pink">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12 6 12 12 16 14"/>
        </svg>
      </div>
      @php $pct = $activeSurveys > 0 ? round(($activeSurveys / ($totalSurveys > 0 ? $totalSurveys : 1)) * 100) : 0; @endphp
      <div class="stat-number">{{ $pct }}<span style="font-size:22px;color:#bbb;">%</span></div>
      <div class="stat-label">Encuestas Activas</div>
      <div class="progress-wrap">
        <div class="progress-track">
          <div class="progress-fill" style="width: {{ $pct }}%"></div>
        </div>
        <div class="progress-label">Porcentaje de actividad</div>
      </div>
    </div>
  </div>

  <div class="charts-grid">
    <div class="chart-card">
      <div class="chart-card-header">
        <div>
          <div class="chart-eyebrow">Rendimiento</div>
          <div class="chart-title">Top Encuestas</div>
        </div>
      </div>
      <div class="chart-area">
        <canvas id="barChart"></canvas>
      </div>
    </div>

    <div class="chart-card">
      <div class="chart-card-header">
        <div>
          <div class="chart-eyebrow">Distribución</div>
          <div class="chart-title">Estado de Encuestas</div>
        </div>
      </div>
      <div class="chart-area-donut">
        <canvas id="doughnutChart"></canvas>
      </div>
      <div class="donut-legend">
        <div class="legend-item">
          <div class="legend-dot" style="background: #1a4a1a;"></div>
          Activas
        </div>
        <div class="legend-item">
          <div class="legend-dot" style="background: var(--oro);"></div>
          Inactivas
        </div>
      </div>
    </div>
  </div>

  <div class="recent-section">
    <div class="recent-header">
      <h3 class="recent-title">Encuestas Recientes</h3>
    </div>

    <div class="surveys-grid">
      @forelse($recentSurveys as $survey)
        <div class="survey-item">
          <a href="{{ route('surveys.show', $survey->id) }}" class="absolute inset-0 z-10" style="position:absolute;inset:0;z-index:10;"></a>

          <div class="survey-item-top">
            <div style="min-width:0;">
              <div class="survey-name">{{ $survey->title }}</div>
              <div class="survey-desc">{{ $survey->description }}</div>
            </div>
            <span class="status-pill {{ $survey->is_active ? 'pill-active' : 'pill-inactive' }}">
              {{ $survey->is_active ? 'Activa' : 'Inactiva' }}
            </span>
          </div>

          <div class="survey-meta">
            <div class="meta-chip">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
              {{ \Carbon\Carbon::parse($survey->created_at)->format('d/m/Y') }}
            </div>

            @if(isset($survey->settings['anonymous']) && $survey->settings['anonymous'])
              <div class="meta-chip chip-anon">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Anónima
              </div>
            @endif

            <div class="meta-chip chip-count">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
              </svg>
              {{ $survey->responses()->count() }}
            </div>
          </div>
        </div>
      @empty
        <div class="empty-state">
          <div class="empty-icon">📋</div>
          <p class="empty-text">No has creado encuestas todavía.</p>
        </div>
      @endforelse
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const ctxBar = document.getElementById('barChart').getContext('2d');
  const chartLabels = @json($chartLabels);
  const chartData   = @json($chartData);

  new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: chartLabels.length > 0 ? chartLabels : ['Sin datos'],
      datasets: [{
        label: 'Respuestas',
        data: chartData.length > 0 ? chartData : [0],
        backgroundColor: (ctx) => {
          const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 240);
          gradient.addColorStop(0, '#2D6A2D');
          gradient.addColorStop(1, '#4a8f4a');
          return gradient;
        },
        borderRadius: 8,
        barThickness: 36,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1a4a1a',
          titleFont: { family: 'DM Mono', size: 10 },
          bodyFont: { family: 'DM Sans', size: 13 },
          padding: 10,
          cornerRadius: 8,
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: { color: 'rgba(0,0,0,0.04)', borderDash: [4,4] },
          ticks: {
            font: { family: 'DM Mono', size: 10 },
            color: '#aaa',
          }
        },
        x: {
          grid: { display: false },
          ticks: {
            font: { family: 'DM Sans', size: 11 },
            color: '#888',
          }
        }
      }
    }
  });

  const ctxDoughnut  = document.getElementById('doughnutChart').getContext('2d');
  const doughnutData = @json($doughnutData);

  new Chart(ctxDoughnut, {
    type: 'doughnut',
    data: {
      labels: ['Activas', 'Inactivas'],
      datasets: [{
        data: doughnutData[0] + doughnutData[1] > 0 ? doughnutData : [1, 0],
        backgroundColor: ['#1a4a1a', '#C9A84C'],
        borderWidth: 0,
        hoverOffset: 6,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '78%',
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1a4a1a',
          titleFont: { family: 'DM Mono', size: 10 },
          bodyFont: { family: 'DM Sans', size: 13 },
          padding: 10,
          cornerRadius: 8,
        }
      }
    }
  });
</script>
@endpush
