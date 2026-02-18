<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIEI UAEMex - @yield('title', 'Mi Espacio')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --uaemex-gold: #C9A961;
            --uaemex-gold-dark: #A68B4E;
            --uaemex-green: #006838;
            --uaemex-green-dark: #004D28;
            --uaemex-green-light: #00814A;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
            --success: #059669;
            --warning: #D97706;
            --danger: #DC2626;
            --info: #2563EB;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        body {
            font-family: 'IBM Plex Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .top-bar {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
        }

        .bar-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .university-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .shield {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-gold) 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 1rem;
        }

        .brand-info h1 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .brand-info p {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-weight: 500;
        }

        .nav-menu {
            display: flex;
            gap: 0.25rem;
        }

        .nav-link {
            padding: 0.625rem 1rem;
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9375rem;
            border-radius: 8px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link:hover {
            background: var(--gray-100);
            color: var(--gray-900);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-green-light) 100%);
            color: white;
        }

        .bar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            border-radius: 8px;
            width: 280px;
            transition: all 0.2s;
        }

        .search-box:focus-within {
            background: white;
            border-color: var(--uaemex-green);
            box-shadow: 0 0 0 3px rgba(0, 104, 56, 0.1);
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            flex: 1;
            font-size: 0.875rem;
            color: var(--gray-900);
        }

        .search-box input::placeholder {
            color: var(--gray-400);
        }

        .icon-button {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 1px solid var(--gray-200);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .icon-button:hover {
            background: var(--gray-50);
            border-color: var(--gray-300);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            cursor: default;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-gold) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 0.875rem;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--gray-900);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
        }

        .welcome-section {
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-green-dark) 100%);
            border-radius: 16px;
            padding: 2.5rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(201, 169, 97, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
        }

        .greeting {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .greeting-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .quick-stat {
            display: flex;
            flex-direction: column;
        }

        .quick-stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            font-variant-numeric: tabular-nums;
        }

        .quick-stat-label {
            font-size: 0.9375rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .action-card {
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 1.75rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
            text-decoration: none;
            color: inherit;
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--uaemex-green);
        }

        .action-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            flex-shrink: 0;
        }

        .action-icon.primary {
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-green-light) 100%);
        }

        .action-icon.gold {
            background: linear-gradient(135deg, var(--uaemex-gold) 0%, var(--uaemex-gold-dark) 100%);
        }

        .action-icon.blue {
            background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%);
        }

        .action-content h3 {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--gray-900);
        }

        .action-content p {
            font-size: 0.9375rem;
            color: var(--gray-600);
            line-height: 1.5;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 1.75rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.75rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gray-100);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .view-all-link {
            color: var(--uaemex-green);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9375rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.2s;
        }

        .view-all-link:hover {
            gap: 0.625rem;
        }

        .survey-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .survey-item {
            padding: 1.25rem;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .survey-item:hover {
            border-color: var(--uaemex-green);
            box-shadow: var(--shadow-md);
        }

        .survey-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .survey-title {
            font-size: 1.0625rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .survey-meta {
            display: flex;
            gap: 1.25rem;
            font-size: 0.8125rem;
            color: var(--gray-500);
        }

        .survey-meta span {
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .status-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            font-size: 0.8125rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .status-badge.active {
            background: rgba(5, 150, 105, 0.1);
            color: var(--success);
        }

        .status-badge.draft {
            background: rgba(107, 114, 128, 0.1);
            color: var(--gray-600);
        }

        .status-badge.closed {
            background: rgba(220, 38, 38, 0.1);
            color: var(--danger);
        }

        .survey-stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .survey-stat {
            text-align: center;
        }

        .survey-stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
            font-variant-numeric: tabular-nums;
        }

        .survey-stat-label {
            font-size: 0.8125rem;
            color: var(--gray-500);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .activity-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            transition: all 0.2s;
            margin-bottom: 0.5rem;
        }

        .activity-item:hover {
            background: var(--gray-50);
        }

        .activity-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .activity-icon-box.green {
            background: rgba(0, 104, 56, 0.1);
        }

        .activity-icon-box.gold {
            background: rgba(201, 169, 97, 0.1);
        }

        .activity-icon-box.blue {
            background: rgba(37, 99, 235, 0.1);
        }

        .activity-info {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            font-size: 0.9375rem;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .activity-description {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .activity-time {
            font-size: 0.8125rem;
            color: var(--gray-400);
            font-weight: 500;
        }

        .templates-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }

        .template-card {
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .template-card:hover {
            transform: translateY(-2px);
            border-color: var(--uaemex-gold);
            box-shadow: var(--shadow-lg);
        }

        .template-icon-box {
            width: 52px;
            height: 52px;
            background: var(--gray-100);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .template-title {
            font-size: 1.0625rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--gray-900);
        }

        .template-description {
            font-size: 0.875rem;
            color: var(--gray-600);
            line-height: 1.5;
            margin-bottom: 0.75rem;
        }

        .template-uses {
            font-size: 0.8125rem;
            color: var(--gray-500);
            font-weight: 600;
        }

        .chart-area {
            height: 280px;
            background: var(--gray-50);
            border: 2px dashed var(--gray-300);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
        }

        .chart-placeholder {
            text-align: center;
        }

        .chart-placeholder-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9375rem;
            font-family: inherit;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-green-light) 100%);
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-outline {
            background: white;
            border: 2px solid var(--gray-300);
            color: var(--gray-700);
        }

        .btn-outline:hover {
            border-color: var(--gray-400);
            background: var(--gray-50);
        }

        @media (max-width: 1200px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .templates-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1.5rem 1rem;
            }

            .nav-menu {
                display: none;
            }

            .search-box {
                width: 200px;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .greeting {
                font-size: 1.5rem;
            }

            .quick-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="bar-left">
            <div class="university-brand">
                <div class="shield">🎓</div>
                <div class="brand-info">
                    <h1>SIEI - UAEMex</h1>
                    <p>Sistema de Encuestas</p>
                </div>
            </div>
            <nav class="nav-menu">
                <a href="{{ route('editor.dashboard') }}" class="nav-link {{ request()->routeIs('editor.dashboard') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Mi Espacio
                </a>
                <a href="{{ route('surveys.index') }}" class="nav-link {{ request()->routeIs('surveys.*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Mis Encuestas
                </a>
                <a href="{{ route('statistics.index') }}" class="nav-link {{ request()->routeIs('statistics.*') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Estadísticas
                </a>
            </nav>
        </div>
        <div class="bar-right">
            <div class="search-box">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: var(--gray-400);">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" placeholder="Buscar encuestas o respuestas">
            </div>
            <div class="user-menu">
                <div class="user-avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
                <div class="user-details">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">
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
                <button type="submit" class="icon-button" title="Cerrar sesión">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>

