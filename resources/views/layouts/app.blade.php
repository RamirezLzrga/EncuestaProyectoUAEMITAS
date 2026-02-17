<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIEI UAEMex - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .bg-uaemex-dark { background-color: #1b393b; }
        .bg-uaemex { background-color: #0d5c41; }
        .text-uaemex { color: #0d5c41; }
        .btn-uaemex { background-color: #0d5c41; }
        .app-light {
            background: radial-gradient(circle at top left, #e0f2f1 0, #f1f5f9 45%, #e5e7eb 100%);
        }
        .dark-mode { background-color: #020617; color: #e5e7eb; }
        .dark-mode .bg-gray-50 { background-color: #020617; }
        .dark-mode .bg-white { background-color: #020617; }
        .dark-mode .text-gray-800 { color: #e5e7eb; }
        .dark-mode .text-gray-700 { color: #e5e7eb; }
        .dark-mode .text-gray-600 { color: #d1d5db; }
        .dark-mode .text-gray-500 { color: #9ca3af; }
        .dark-mode .border-gray-200 { border-color: #1f2937; }
        .dark-mode .border-gray-100 { border-color: #1f2937; }
        .dark-mode input,
        .dark-mode select,
        .dark-mode textarea { background-color: #020617; color: #e5e7eb; border-color: #374151; }
        .dark-mode .shadow-sm { box-shadow: 0 1px 2px 0 rgba(15,23,42,0.7); }
        .sidebar-active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #d4af37;
        }
        .text-gold { color: #d4af37; }
        .bg-gold { background-color: #d4af37; }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    </style>
    @stack('styles')
</head>
@php
    $systemConfig = \App\Models\SystemConfig::first();
    $darkModeEnabled = $systemConfig && !empty($systemConfig->general['dark_mode']);
@endphp
<body class="font-sans flex h-screen overflow-hidden {{ $darkModeEnabled ? 'dark-mode' : 'app-light' }}">

    <aside class="w-72 bg-uaemex-dark/95 text-white flex flex-col shadow-2xl z-20">
        <div class="p-6 flex items-center gap-3">
            <div class="bg-gold text-uaemex-dark font-bold p-2 rounded-lg h-10 w-10 flex items-center justify-center text-xl">UA</div>
            <div>
                <h1 class="text-lg font-bold tracking-wide">SIEI UAEMex</h1>
                <p class="text-[11px] text-gray-300 mt-1">Encuestas institucionales</p>
            </div>
        </div>

        <nav class="flex-1 px-4 space-y-5 mt-4 overflow-y-auto">
            <div>
                <button type="button" class="w-full flex items-center justify-between text-xs font-bold text-gray-300 uppercase mb-1 px-2 tracking-wider group-toggle" data-target="group-principal">
                    <span>Principal</span>
                    <i class="fas fa-chevron-down text-[10px] transition-transform group-icon"></i>
                </button>
                <div id="group-principal" class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'sidebar-active' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }} text-white font-medium transition-all duration-200">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fas fa-chart-pie w-5"></i>
                        </div>
                        <div class="flex flex-col">
                            <span>Dashboard</span>
                            <span class="text-[11px] text-gray-400">Resumen general</span>
                        </div>
                    </a>
                    <a href="{{ route('surveys.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('surveys.*') ? 'sidebar-active' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }} transition-all duration-200">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fas fa-clipboard-list w-5"></i>
                        </div>
                        <div class="flex flex-col">
                            <span>Encuestas</span>
                            <span class="text-[11px] text-gray-400">Crear y gestionar</span>
                        </div>
                    </a>
                    <a href="{{ route('statistics.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('statistics.*') ? 'sidebar-active' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }} transition-all duration-200">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fas fa-chart-line w-5"></i>
                        </div>
                        <div class="flex flex-col">
                            <span>Estadísticas</span>
                            <span class="text-[11px] text-gray-400">Resultados agregados</span>
                        </div>
                    </a>
                </div>
            </div>

            @if(Auth::user()->role === 'admin')
            <div>
                <button type="button" class="w-full flex items-center justify-between text-xs font-bold text-gray-300 uppercase mb-1 px-2 tracking-wider group-toggle" data-target="group-admin">
                    <span>Administración</span>
                    <i class="fas fa-chevron-down text-[10px] transition-transform group-icon"></i>
                </button>
                <div id="group-admin" class="space-y-1">
                    <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('users.*') ? 'sidebar-active' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }} transition-all duration-200">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fas fa-users w-5"></i>
                        </div>
                        <div class="flex flex-col">
                            <span>Usuarios</span>
                            <span class="text-[11px] text-gray-400">Control de accesos</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.aprobaciones') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.aprobaciones') ? 'sidebar-active' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }} transition-all duration-200">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fas fa-check-square w-5"></i>
                        </div>
                        <div class="flex flex-col">
                            <span>Aprobaciones</span>
                            <span class="text-[11px] text-gray-400">Revisión de encuestas</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.reportes') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.reportes') ? 'sidebar-active' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }} transition-all duration-200">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fas fa-file-alt w-5"></i>
                        </div>
                        <div class="flex flex-col">
                            <span>Reportes</span>
                            <span class="text-[11px] text-gray-400">Informes globales</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.monitor') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.monitor') ? 'sidebar-active' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }} transition-all duration-200">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fas fa-heartbeat w-5"></i>
                        </div>
                        <div class="flex flex-col">
                            <span>Monitor</span>
                            <span class="text-[11px] text-gray-400">Actividad en tiempo real</span>
                        </div>
                    </a>
                </div>
            </div>

            <div>
                <button type="button" class="w-full flex items-center justify-between text-xs font-bold text-gray-300 uppercase mb-1 px-2 tracking-wider group-toggle" data-target="group-settings">
                    <span>Configuración</span>
                    <i class="fas fa-chevron-down text-[10px] transition-transform group-icon"></i>
                </button>
                <div id="group-settings" class="space-y-1">
                    <a href="{{ route('admin.configuracion') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.configuracion') ? 'sidebar-active' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent' }} transition-all duration-200">
                        <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fas fa-cog w-5"></i>
                        </div>
                        <div class="flex flex-col">
                            <span>Sistema</span>
                            <span class="text-[11px] text-gray-400">Preferencias globales</span>
                        </div>
                    </a>
                </div>
            </div>
            @endif
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <header class="bg-white/80 backdrop-blur border-b border-gray-200/60 px-8 py-4 flex justify-end items-center gap-4 sticky top-0 z-30 shadow-sm">
            <div class="relative">
                <button id="notificationsBtn" class="flex items-center justify-center w-11 h-11 rounded-full bg-white border border-gray-200 hover:border-[#d4af37] text-gray-600 hover:text-[#d4af37] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#d4af37]/50 shadow-sm active:scale-95">
                    <span class="relative">
                        <i class="fas fa-bell text-lg"></i>
                        <span id="notificationsBadge" class="hidden absolute -top-2 -right-2 w-4 h-4 rounded-full bg-red-500 text-[9px] text-white flex items-center justify-center font-bold"></span>
                    </span>
                </button>

                <div id="notificationsDropdown" class="hidden absolute right-0 mt-3 w-80 bg-[#1b393b] rounded-xl shadow-2xl border border-white/10 overflow-hidden transform origin-top-right transition-all duration-200 z-50">
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs font-semibold tracking-widest uppercase text-gray-300">Notificaciones</p>
                            <button id="notificationsMarkAll" class="text-[10px] text-emerald-300 hover:text-emerald-200 font-semibold uppercase tracking-wider">Marcar todas como leídas</button>
                        </div>
                        <div id="notificationsList" class="space-y-2 max-h-64 overflow-y-auto text-xs text-gray-100">
                            <p class="text-gray-400 text-[11px]">No tienes notificaciones nuevas.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <button id="userMenuBtn" class="flex items-center justify-center w-12 h-12 rounded-full bg-white border border-gray-200 hover:border-[#d4af37] text-gray-600 hover:text-[#d4af37] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-[#d4af37]/50 shadow-sm active:scale-95 group">
                    <i class="fas fa-user text-xl group-hover:scale-110 transition-transform"></i>
                </button>

                <!-- Floating Dropdown Bubble -->
                <div id="userMenuDropdown" class="hidden absolute right-0 mt-3 w-72 bg-[#1b393b] rounded-xl shadow-2xl border border-white/10 overflow-hidden transform origin-top-right transition-all duration-200 z-50">
                    <div class="p-5">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-[#d4af37] flex items-center justify-center text-white font-bold text-lg shadow-inner">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-white font-bold text-base truncate uppercase tracking-wide">{{ Auth::user()->name }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                    @if(Auth::user()->role === 'admin') bg-purple-500/20 text-purple-200 border border-purple-500/30
                                    @elseif(Auth::user()->role === 'editor') bg-blue-500/20 text-blue-200 border border-blue-500/30
                                    @else bg-gray-500/20 text-gray-200 border border-gray-500/30 @endif">
                                    @switch(Auth::user()->role)
                                        @case('admin') Administrador @break
                                        @case('editor') Editor @break
                                        @default Usuario
                                    @endswitch
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-500/10 hover:bg-red-500/20 text-red-300 hover:text-red-200 text-sm font-bold uppercase tracking-wider transition py-3 rounded-lg border border-red-500/20 group">
                                <i class="fas fa-sign-out-alt group-hover:-translate-x-1 transition-transform"></i>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-8 space-y-8 max-w-7xl mx-auto w-full">
            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuBtn = document.getElementById('userMenuBtn');
            const userMenuDropdown = document.getElementById('userMenuDropdown');

            if (userMenuBtn && userMenuDropdown) {
                userMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userMenuDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!userMenuBtn.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                        userMenuDropdown.classList.add('hidden');
                    }
                });
            }

            const toggles = document.querySelectorAll('.group-toggle');
            toggles.forEach(function(btn) {
                const targetId = btn.getAttribute('data-target');
                const target = document.getElementById(targetId);
                const icon = btn.querySelector('.group-icon');

                if (target && icon) {
                    btn.addEventListener('click', function() {
                        target.classList.toggle('hidden');
                        icon.classList.toggle('rotate-180');
                    });
                }
            });

            const notificationsBtn = document.getElementById('notificationsBtn');
            const notificationsDropdown = document.getElementById('notificationsDropdown');
            const notificationsBadge = document.getElementById('notificationsBadge');
            const notificationsList = document.getElementById('notificationsList');
            const notificationsMarkAll = document.getElementById('notificationsMarkAll');

            function renderNotifications(data) {
                if (!notificationsList || !notificationsBadge) {
                    return;
                }

                notificationsList.innerHTML = '';

                if (!data.items || data.items.length === 0) {
                    const p = document.createElement('p');
                    p.className = 'text-gray-400 text-[11px]';
                    p.textContent = 'No tienes notificaciones nuevas.';
                    notificationsList.appendChild(p);
                } else {
                    data.items.forEach(function(item) {
                        const div = document.createElement('div');
                        div.className = 'bg-white/5 border border-white/10 rounded-lg px-3 py-2';

                        const title = document.createElement('p');
                        title.className = 'text-[11px] font-semibold text-white';
                        title.textContent = item.title;
                        div.appendChild(title);

                        const msg = document.createElement('p');
                        msg.className = 'text-[11px] text-gray-300 mt-1';
                        msg.textContent = item.message;
                        div.appendChild(msg);

                        const meta = document.createElement('p');
                        meta.className = 'text-[10px] text-gray-500 mt-1';
                        meta.textContent = item.created_at;
                        div.appendChild(meta);

                        notificationsList.appendChild(div);
                    });
                }

                if (data.count && data.count > 0) {
                    notificationsBadge.classList.remove('hidden');
                    notificationsBadge.textContent = data.count > 9 ? '9+' : data.count;
                } else {
                    notificationsBadge.classList.add('hidden');
                }
            }

            function fetchNotifications() {
                if (!notificationsList) {
                    return;
                }

                fetch("{{ route('notifications.unread') }}", {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        renderNotifications(data);
                    })
                    .catch(function() {});
            }

            if (notificationsBtn && notificationsDropdown) {
                notificationsBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notificationsDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!notificationsBtn.contains(e.target) && !notificationsDropdown.contains(e.target)) {
                        notificationsDropdown.classList.add('hidden');
                    }
                });
            }

            if (notificationsMarkAll) {
                notificationsMarkAll.addEventListener('click', function(e) {
                    e.preventDefault();
                    fetch("{{ route('notifications.markAllRead') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    })
                        .then(function(response) {
                            return response.json();
                        })
                        .then(function() {
                            fetchNotifications();
                        })
                        .catch(function() {});
                });
            }

            fetchNotifications();
            setInterval(fetchNotifications, 15000);
        });
    </script>
    @stack('scripts')
</body>
</html>
