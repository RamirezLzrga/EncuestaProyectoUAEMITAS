@extends('layouts.admin_softui')

@section('title', 'Reportes Globales')

@section('content')
<div class="dashboard-wrap">
    <div class="dash-header">
        <div>
            <div class="dash-eyebrow">SIEI UAEMex</div>
            <h2 class="dash-title">Reportes Globales</h2>
            <p class="dash-subtitle">Genera y programa reportes globales del sistema.</p>
        </div>
    </div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-6">
    <div class="xl:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-filter text-uaemex"></i>
                Configuración del reporte
            </h2>

            <form method="GET" action="{{ route('admin.reportes') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Período</label>
                        <select name="period" class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-uaemex">
                            <option value="hoy" {{ $period === 'hoy' ? 'selected' : '' }}>Hoy</option>
                            <option value="semana" {{ $period === 'semana' ? 'selected' : '' }}>Esta semana</option>
                            <option value="mes" {{ $period === 'mes' ? 'selected' : '' }}>Este mes</option>
                            <option value="año" {{ $period === 'año' ? 'selected' : '' }}>Este año</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Formato</label>
                        <div class="flex gap-2">
                            <button type="button" class="flex-1 px-3 py-2 rounded-lg border border-gray-300 text-xs text-gray-700 hover:bg-gray-50 flex items-center justify-center gap-2">
                                <i class="fas fa-file-pdf text-red-500"></i>
                                PDF
                            </button>
                            <button type="button" class="flex-1 px-3 py-2 rounded-lg border border-gray-300 text-xs text-gray-700 hover:bg-gray-50 flex items-center justify-center gap-2">
                                <i class="fas fa-file-excel text-green-600"></i>
                                Excel
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="block text-xs font-semibold text-gray-500 mb-2">Métricas a incluir</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach($availableMetrics as $key => $label)
                            <label class="flex items-center gap-2 text-xs text-gray-600">
                                <input type="checkbox" class="rounded border-gray-300 text-uaemex focus:ring-uaemex" checked disabled>
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-uaemex text-white text-xs font-semibold hover:bg-emerald-700 transition flex items-center gap-2">
                        <i class="fas fa-sync-alt"></i>
                        Actualizar
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-eye text-uaemex"></i>
                Vista previa del reporte
            </h2>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="space-y-2">
                    <p class="text-xs text-gray-500">Resumen</p>
                    <p class="text-gray-700">Encuestas enviadas: <span class="font-semibold">{{ $preview['summary']['encuestas_enviadas'] }}</span></p>
                    <p class="text-gray-700">Encuestas completadas: <span class="font-semibold">{{ $preview['summary']['encuestas_completadas'] }}</span></p>
                    <p class="text-gray-700">Tasa de respuesta: <span class="font-semibold">{{ $preview['summary']['tasa_respuesta'] }}%</span></p>
                </div>
                <div class="space-y-2">
                    <p class="text-xs text-gray-500">Satisfacción promedio</p>
                    <p class="text-3xl font-bold text-uaemex">{{ number_format($preview['summary']['satisfaccion_promedio'], 1) }}</p>
                    <p class="text-xs text-gray-500">Escala de 1 a 5</p>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-clock text-uaemex"></i>
                Programar reportes
            </h2>

            <div class="space-y-3 text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox" class="rounded border-gray-300 text-uaemex focus:ring-uaemex">
                    Enviar reporte diario al correo institucional
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" class="rounded border-gray-300 text-uaemex focus:ring-uaemex">
                    Enviar reporte semanal a coordinadores
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" class="rounded border-gray-300 text-uaemex focus:ring-uaemex">
                    Enviar reporte mensual a dirección
                </label>
            </div>

            <div class="mt-4">
                <button class="w-full px-4 py-2 rounded-lg bg-uaemex text-white text-sm font-semibold hover:bg-emerald-700 transition flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i>
                    Guardar programación
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-history text-uaemex"></i>
                Historial de reportes
            </h2>

            <div class="space-y-3 max-h-64 overflow-y-auto text-sm">
                @foreach($history as $item)
                    <div class="border rounded-lg p-3 flex items-center justify-between gap-3">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-500">
                                Generado {{ $item['generated_at']->diffForHumans() }}
                            </p>
                        </div>
                        <button class="px-3 py-1 rounded-lg border border-gray-300 text-xs text-gray-700 hover:bg-gray-50 flex items-center gap-1">
                            <i class="fas fa-download"></i>
                            {{ $item['format'] }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>
@endsection
