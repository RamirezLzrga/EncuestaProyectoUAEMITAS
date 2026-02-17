@extends('layouts.app')

@section('title', 'Compartir Encuesta')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <p class="text-xs uppercase tracking-widest text-gray-400 font-semibold">Compartir</p>
        <h1 class="text-2xl font-bold text-gray-100 mt-1">{{ $survey->title }}</h1>
    </div>
    <a href="{{ route('editor.encuestas.editar', $survey) }}" class="px-4 py-2 rounded-full border border-gray-500/40 text-gray-300 text-xs font-semibold hover:bg-white/5 transition flex items-center gap-2">
        <i class="fas fa-pen"></i>
        Volver al editor
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2 space-y-5">
        <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-5 space-y-4">
            <h2 class="text-sm font-semibold text-gray-100 flex items-center gap-2">
                <i class="fas fa-link text-emerald-400"></i>
                Enlace directo
            </h2>
            <div class="flex items-center gap-2 text-xs">
                <input type="text" readonly value="{{ $publicLink }}" class="flex-1 bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 focus:outline-none">
                <button type="button" onclick="navigator.clipboard.writeText('{{ $publicLink }}')" class="px-3 py-2 rounded-xl bg-emerald-500 text-white font-semibold hover:bg-emerald-600 transition">
                    Copiar
                </button>
            </div>
            <p class="text-[11px] text-gray-500">Este es el enlace público que puedes compartir por cualquier canal.</p>
        </div>

        <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-5 space-y-4">
            <h2 class="text-sm font-semibold text-gray-100 flex items-center gap-2">
                <i class="fas fa-envelope text-sky-400"></i>
                Invitación por correo
            </h2>
            <p class="text-xs text-gray-400">Puedes copiar este texto base para invitar a tus participantes. El envío masivo de correos se puede automatizar en una iteración posterior.</p>
            <textarea rows="4" class="w-full bg-slate-950/60 border border-white/10 rounded-xl px-3 py-2 text-gray-100 text-xs focus:outline-none">
Hola,

Te invitamos a responder la siguiente encuesta:
{{ $survey->title }}

Accede desde este enlace: {{ $publicLink }}

Gracias por tu participación.
            </textarea>
        </div>
    </div>

    <div class="space-y-5">
        <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-5 space-y-3">
            <h2 class="text-sm font-semibold text-gray-100 flex items-center gap-2">
                <i class="fas fa-qrcode text-fuchsia-400"></i>
                Código QR
            </h2>
            <div class="bg-slate-950/80 border border-white/10 rounded-2xl aspect-square flex items-center justify-center">
                <p class="text-[11px] text-gray-500 px-4 text-center">La generación automática de QR se puede agregar integrando una librería como simplesoftwareio/simple-qrcode.</p>
            </div>
            <p class="text-[11px] text-gray-500">Escanea o imprime el QR para captar respuestas de forma presencial.</p>
        </div>

        <div class="bg-slate-900/60 border border-white/10 rounded-2xl p-5 space-y-3 text-xs">
            <h2 class="text-sm font-semibold text-gray-100 flex items-center gap-2">
                <i class="fas fa-bullhorn text-amber-400"></i>
                Resumen de estado
            </h2>
            <p class="flex items-center justify-between">
                <span class="text-gray-400">Estado de aprobación</span>
                <span class="text-gray-100 font-semibold">{{ strtoupper($survey->approval_status ?? 'PENDING') }}</span>
            </p>
            <p class="flex items-center justify-between">
                <span class="text-gray-400">Encuesta activa</span>
                <span class="text-gray-100 font-semibold">{{ $survey->is_active ? 'Sí' : 'No' }}</span>
            </p>
            <p class="text-[11px] text-gray-500 mt-2">El flujo completo de aprobación ya está gestionado desde el panel de administrador.</p>
        </div>
    </div>
</div>
@endsection

