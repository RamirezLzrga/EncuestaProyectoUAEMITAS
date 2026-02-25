@extends('layouts.admin_softui')

@section('title', 'Encuestas')

@section('content')
    <div class="ph">
        <div>
            <div class="ph-label">Gestión</div>
            <div class="ph-title">Encuestas Globales</div>
            <div class="ph-sub">Administra y monitorea todas las encuestas del sistema</div>
        </div>
        <a href="{{ route('surveys.create') }}" class="btn btn-solid">+ Nueva Encuesta</a>
    </div>

    <div class="surveys-layout">
        <form action="{{ route('surveys.index') }}" method="GET" id="filtersForm" class="filter-neu">
            <span class="fn-label">Desde:</span>
            <input type="text" id="datepicker" name="start_date" value="{{ request('start_date') }}" class="fn-input" placeholder="Seleccionar...">
            <span class="fn-label">Estado:</span>
            <select name="status" onchange="this.form.submit()" class="fn-input">
                <option value="Todas" {{ request('status') == 'Todas' ? 'selected' : '' }}>Todas</option>
                <option value="Activas" {{ request('status') == 'Activas' ? 'selected' : '' }}>Activas</option>
                <option value="Inactivas" {{ request('status') == 'Inactivas' ? 'selected' : '' }}>Inactivas</option>
            </select>
            <div class="fn-search" style="flex:1">
                <span class="fn-search-icon">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar encuesta..." class="fn-input" style="box-shadow:none;padding:0;flex:1">
            </div>
            <a href="{{ route('surveys.index') }}" class="btn btn-neu btn-sm">↺ Limpiar</a>
        </form>

        @if(session('success'))
            <div class="badge-neu bn-green">{{ session('success') }}</div>
        @endif

        @if($surveys->count() > 0)
            <div class="surveys-grid">
                @foreach ($surveys as $survey)
                    <div class="survey-card">
                        <div class="sc-banner {{ $survey->is_active ? 'activa' : 'pendiente' }}"></div>
                        <div class="sc-body">
                            <div class="sc-top">
                                <div>
                                    <div class="sc-name">{{ $survey->title }}</div>
                                    <div class="sc-desc">{{ $survey->description ?: 'Sin descripción' }}</div>
                                </div>
                                <span class="badge-neu {{ $survey->is_active ? 'bn-green' : 'bn-gold' }}">
                                    {{ $survey->is_active ? '● Activa' : '○ Pendiente' }}
                                </span>
                            </div>
                            <div class="sc-stats">
                                <div class="sc-stat"><div class="sc-stat-val">{{ $survey->responses()->count() }}</div><div class="sc-stat-label">Resp.</div></div>
                                <div class="sc-stat"><div class="sc-stat-val">{{ count($survey->questions ?? []) }}</div><div class="sc-stat-label">Preg.</div></div>
                                <div class="sc-stat"><div class="sc-stat-val">{{ $survey->limit_responses ? intval(($survey->responses()->count()/$survey->limit_responses)*100) : '—' }}@if($survey->limit_responses)%@endif</div><div class="sc-stat-label">Comp.</div></div>
                            </div>
                            <div class="sc-author">
                                <div class="sc-avatar">{{ strtoupper(substr($survey->user->name ?? '?',0,1)) }}</div>
                                <span>{{ strtoupper($survey->user->name ?? 'Desconocido') }} · {{ $survey->created_at? $survey->created_at->format('d/m/Y') : 'N/A' }}</span>
                            </div>
                            <div class="sc-actions">
                                <a href="{{ route('surveys.public', $survey->id) }}" target="_blank" class="sc-btn">↗ Abrir</a>
                                <a href="{{ route('surveys.show', $survey->id) }}" class="sc-btn">👁 Ver</a>
                                <a href="{{ route('surveys.edit', $survey->id) }}" class="sc-btn">✏ Editar</a>
                                <form action="{{ route('surveys.toggle-status', $survey->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="sc-btn {{ $survey->is_active ? 'del' : '' }}" title="{{ $survey->is_active ? 'Inhabilitar' : 'Habilitar' }}">
                                        {{ $survey->is_active ? '✕' : '✔' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="badge-neu" style="color:var(--text-muted)">No se encontraron encuestas</div>
        @endif
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Personalización de Flatpickr */
        .flatpickr-day.has-survey {
            background: #e6fffa;
            border-color: transparent;
            position: relative;
        }
        .flatpickr-day.has-survey::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background-color: #3b5f39; /* Color UAEMex */
            border-radius: 50%;
        }
        .flatpickr-day.selected.has-survey {
            background: #3b5f39;
            border-color: #3b5f39;
            color: #fff;
        }
        .flatpickr-day.selected.has-survey::after {
            background-color: #fff;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fechas con encuestas pasadas desde el controlador
            const surveyDates = @json($surveyDates ?? []);

            flatpickr("#datepicker", {
                locale: "es",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                allowInput: true,
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    // Formatear la fecha del día actual en el loop
                    const date = dayElem.dateObj.toISOString().slice(0, 10);
                    
                    // Si la fecha está en nuestra lista, agregar clase
                    if (surveyDates.includes(date)) {
                        dayElem.classList.add('has-survey');
                        dayElem.title = "Hay encuestas este día";
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    // Enviar el formulario al seleccionar fecha
                    document.getElementById('filtersForm').submit();
                }
            });
        });
    </script>
@endpush
