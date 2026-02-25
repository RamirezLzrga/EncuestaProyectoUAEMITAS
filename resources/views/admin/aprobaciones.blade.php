@extends('layouts.admin_softui')

@section('title', 'Sistema de Aprobaciones')

@section('content')
<div class="page-header">
    <div class="page-title-row">
        <div>
            <h1 class="page-title">Sistema de Aprobaciones</h1>
            <p class="page-subtitle">Cola de encuestas pendientes de aprobación y su historial.</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-4">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-inbox text-uaemex"></i>
                    Pendientes de aprobación
                </h2>
                <span class="text-xs px-3 py-1 rounded-full bg-uaemex text-white font-semibold">
                    {{ count($pendingSurveys) }} pendientes
                </span>
            </div>

            @if($pendingSurveys->isEmpty())
                <p class="text-sm text-gray-500">No hay encuestas pendientes de aprobación.</p>
            @else
                <div class="space-y-3">
                    @foreach($pendingSurveys as $survey)
                        <div class="border rounded-lg p-4 flex flex-col gap-3 hover:border-uaemex transition">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $survey->title }}</h3>
                                    <p class="text-xs text-gray-500">
                                        Propietario: <span class="font-medium">{{ optional($survey->user)->name ?? 'Sin asignar' }}</span>
                                        · Creada {{ optional($survey->created_at)->diffForHumans() }}
                                    </p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">
                                    Pendiente
                                </span>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-3 text-xs text-gray-600 space-y-2">
                                <p class="font-semibold mb-1">Preview de la encuesta</p>
                                <div class="flex flex-wrap items-center gap-3 text-[11px] text-gray-500">
                                    <span class="inline-flex items-center gap-1">
                                        <i class="far fa-calendar text-uaemex"></i>
                                        <span>
                                            {{ optional($survey->start_date)->format('d/m/Y') ?? 'Sin fecha de inicio' }}
                                            –
                                            {{ optional($survey->end_date)->format('d/m/Y') ?? 'Sin fecha de cierre' }}
                                        </span>
                                    </span>
                                    @php
                                        $settings = $survey->settings ?? [];
                                        $maxResponses = $settings['max_responses'] ?? null;
                                    @endphp
                                    @if($maxResponses)
                                        <span class="inline-flex items-center gap-1">
                                            <i class="fas fa-users text-gray-400"></i>
                                            <span>Límite: {{ $maxResponses }} respuestas</span>
                                        </span>
                                    @endif
                                    <span class="inline-flex items-center gap-1">
                                        <i class="fas fa-list-ul text-gray-400"></i>
                                        <span>{{ is_array($survey->questions) ? count($survey->questions) : 0 }} preguntas</span>
                                    </span>
                                </div>
                                @if(is_array($survey->questions) && count($survey->questions) > 0)
                                    <div class="border-t border-gray-200 pt-2 mt-1 space-y-1">
                                        @foreach(array_slice($survey->questions, 0, 3) as $index => $question)
                                            <div class="flex items-start justify-between gap-2">
                                                <span class="text-gray-700">
                                                    {{ $index + 1 }}. {{ $question['text'] ?? 'Pregunta sin texto' }}
                                                </span>
                                                @if(!empty($question['type']))
                                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-semibold uppercase">
                                                        {{ str_replace('_', ' ', $question['type']) }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                        @if(count($survey->questions) > 3)
                                            <p class="text-[11px] text-gray-400 mt-1">
                                                + {{ count($survey->questions) - 3 }} preguntas más
                                            </p>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-[11px] text-gray-400">Esta encuesta aún no tiene preguntas configuradas.</p>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('admin.aprobaciones.update', $survey) }}" class="flex items-center gap-3">
                                @csrf
                                <input
                                    type="text"
                                    name="comment"
                                    placeholder="Comentario para el editor (opcional)"
                                    class="flex-1 border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-uaemex"
                                    value="{{ old('comment') }}"
                                >
                                <button
                                    type="submit"
                                    name="decision"
                                    value="reject"
                                    class="px-4 py-2 rounded-lg bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition flex items-center gap-2"
                                >
                                    <i class="fas fa-times"></i>
                                    Rechazar
                                </button>
                                <button
                                    type="submit"
                                    name="decision"
                                    value="approve"
                                    class="px-4 py-2 rounded-lg bg-uaemex text-white text-sm font-semibold hover:bg-emerald-700 transition flex items-center gap-2"
                                >
                                    <i class="fas fa-check"></i>
                                    Aprobar
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-history text-uaemex"></i>
                Historial de aprobaciones
            </h2>

            <div class="flex items-center gap-2 mb-4">
                <button class="px-3 py-1 text-xs rounded-full bg-uaemex text-white font-semibold">Pendientes</button>
                <button class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700 font-semibold">Aprobadas</button>
                <button class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">Rechazadas</button>
            </div>

            <div class="space-y-3 max-h-80 overflow-y-auto">
                @forelse($history as $item)
                    <div class="border rounded-lg p-3 flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $item->title }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $item->approval_status === 'approved' ? 'Aprobada' : 'Rechazada' }}
                                por {{ optional($item->approver)->name ?? 'Administrador' }}
                                · {{ optional($item->approved_at)->diffForHumans() }}
                            </p>
                            @if($item->approval_comment)
                                <p class="text-xs text-gray-400 mt-1">
                                    Comentario: "{{ $item->approval_comment }}"
                                </p>
                            @endif
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full font-semibold
                            @if($item->approval_status === 'approved') bg-emerald-100 text-emerald-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ $item->approval_status === 'approved' ? 'Aprobada' : 'Rechazada' }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Aún no hay historial de aprobaciones.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
