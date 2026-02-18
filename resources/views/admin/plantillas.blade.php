@extends('layouts.admin')

@section('title', 'Plantillas Globales')

@section('content')
<div class="dashboard-wrap">
    <div class="dash-header">
        <div>
            <div class="dash-eyebrow">SIEI UAEMex</div>
            <h2 class="dash-title">Plantillas Globales</h2>
            <p class="dash-subtitle">Gestiona las plantillas base que usarán los editores.</p>
        </div>
    <form
        method="POST"
        action="{{ isset($editingTemplate) ? route('admin.plantillas.update', $editingTemplate) : route('admin.plantillas.store') }}"
        class="flex items-center gap-2"
    >
        @csrf
        @if(isset($editingTemplate))
            @method('PUT')
        @endif
        <input
            type="text"
            name="name"
            placeholder="Nombre de plantilla"
            value="{{ old('name', isset($editingTemplate) ? $editingTemplate->name : '') }}"
            class="border rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-uaemex"
        >
        <select
            name="category"
            class="border rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-uaemex"
        >
            @foreach($categories as $category)
                <option
                    value="{{ $category }}"
                    @if(old('category', isset($editingTemplate) ? $editingTemplate->category : null) === $category) selected @endif
                >
                    {{ $category }}
                </option>
            @endforeach
        </select>
        <label class="flex items-center gap-1 text-xs text-gray-600">
            <input
                type="checkbox"
                name="is_mandatory"
                value="1"
                class="rounded border-gray-300 text-uaemex focus:ring-uaemex"
                @if(old('is_mandatory', isset($editingTemplate) ? $editingTemplate->is_mandatory : false)) checked @endif
            >
            Obligatoria
        </label>
        <button
            type="submit"
            class="px-4 py-2 rounded-lg bg-uaemex text-white text-xs font-semibold hover:bg-emerald-700 transition flex items-center gap-2"
        >
            <i class="fas fa-plus"></i>
            {{ isset($editingTemplate) ? 'Actualizar' : 'Nueva' }}
        </button>
    </form>
    </div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-layer-group text-uaemex"></i>
                Lista de plantillas
            </h2>
            <div class="flex gap-2">
                @foreach($categories as $category)
                    <button class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700 hover:bg-uaemex hover:text-white transition">
                        {{ $category }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="space-y-3">
            @forelse($templates as $template)
                <div class="border rounded-lg p-4 flex items-center justify-between gap-4 hover:border-uaemex transition">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $template->name }}</p>
                        <p class="text-xs text-gray-500">{{ $template->category }}</p>
                        @if($template->is_mandatory)
                            <span class="inline-flex items-center gap-1 mt-1 text-xs px-2 py-0.5 rounded-full bg-gold text-uaemex-dark font-semibold">
                                <i class="fas fa-star"></i>
                                Obligatoria
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <a
                            href="{{ route('admin.plantillas.edit', $template) }}"
                            class="px-3 py-1 rounded-lg border border-gray-300 text-xs text-gray-700 hover:bg-gray-50 flex items-center gap-1"
                        >
                            <i class="fas fa-pen"></i>
                            Editar
                        </a>
                        <form method="POST" action="{{ route('admin.plantillas.destroy', $template) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="px-3 py-1 rounded-lg border border-red-300 text-xs text-red-600 hover:bg-red-50 flex items-center gap-1"
                            >
                                <i class="fas fa-trash"></i>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Aún no hay plantillas creadas.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-file-alt text-uaemex"></i>
            Preview de plantilla
        </h2>
        <p class="text-sm text-gray-600 mb-3">
            Aquí se mostrará una previsualización interactiva de la plantilla seleccionada: estructura de secciones, tipo de preguntas y lógica básica.
        </p>
        <div class="border rounded-lg p-4 text-xs text-gray-500 space-y-2 bg-gray-50">
            <p class="font-semibold text-gray-700">Ejemplo:</p>
            <p>Título: Encuesta de Satisfacción General</p>
            <p>Secciones: Datos generales, Satisfacción, Comentarios.</p>
            <p>Preguntas tipo: escala Likert, opción múltiple y campo abierto.</p>
        </div>
        <div class="mt-4">
            <label class="flex items-center gap-2 text-xs text-gray-600">
                <input type="checkbox" class="rounded border-gray-300 text-uaemex focus:ring-uaemex">
                Marcar como obligatoria para los editores
            </label>
        </div>
    </div>
</div>
</div>
@endsection
