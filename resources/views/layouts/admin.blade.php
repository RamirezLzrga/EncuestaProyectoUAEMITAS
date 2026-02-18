<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIEI UAEMex - @yield('title', 'Panel Administrativo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .top-header {
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-green-dark) 100%);
            color: white;
            padding: 0.75rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .university-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .university-shield {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--uaemex-green);
            font-size: 1.125rem;
            box-shadow: var(--shadow);
        }

        .brand-text h1 {
            font-size: 1.125rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .brand-text p {
            font-size: 0.75rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .system-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            font-size: 0.875rem;
            backdrop-filter: blur(10px);
        }

        .status-indicator {
            width: 8px;
            height: 8px;
            background: #10B981;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon-btn {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .header-icon-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border: 2px solid var(--uaemex-green);
            border-radius: 50%;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            backdrop-filter: blur(10px);
        }

        .user-profile:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--uaemex-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            color: white;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.875rem;
        }

        .user-role {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        .navigation-bar {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 0 2rem;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 72px;
            z-index: 999;
        }

        .nav-tabs {
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
        }

        .nav-tab {
            padding: 1rem 1.5rem;
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9375rem;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-tab:hover {
            color: var(--uaemex-green);
            background: var(--gray-50);
        }

        .nav-tab.active {
            color: var(--uaemex-green);
            border-bottom-color: var(--uaemex-green);
            font-weight: 600;
        }

        .tab-badge {
            background: var(--danger);
            color: white;
            padding: 0.125rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .main-wrapper {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--gray-500);
            font-size: 1rem;
        }

        .page-actions {
            display: flex;
            gap: 0.75rem;
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
            background: var(--uaemex-green);
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            background: var(--uaemex-green-dark);
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: white;
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }

        .btn-secondary:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--uaemex-gold) 0%, var(--uaemex-gold-dark) 100%);
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-gold:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.75rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--uaemex-green) 0%, var(--uaemex-gold) 100%);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--uaemex-green);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--gray-500);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.green {
            background: linear-gradient(135deg, rgba(0, 104, 56, 0.1) 0%, rgba(0, 104, 56, 0.05) 100%);
        }

        .stat-icon.gold {
            background: linear-gradient(135deg, rgba(201, 169, 97, 0.1) 0%, rgba(201, 169, 97, 0.05) 100%);
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
        }

        .stat-value {
            font-size: 2.75rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1;
            margin-bottom: 0.5rem;
            font-variant-numeric: tabular-nums;
        }

        .stat-change {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .stat-change.positive {
            background: rgba(5, 150, 105, 0.1);
            color: var(--success);
        }

        .stat-change.negative {
            background: rgba(220, 38, 38, 0.1);
            color: var(--danger);
        }

        .content-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
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
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gray-100);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-icon {
            width: 32px;
            height: 32px;
            background: var(--uaemex-green);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .card-actions {
            display: flex;
            gap: 0.5rem;
        }

        .filter-chip {
            padding: 0.5rem 1rem;
            border: 1px solid var(--gray-300);
            background: white;
            color: var(--gray-600);
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-chip:hover {
            border-color: var(--uaemex-green);
            color: var(--uaemex-green);
        }

        .filter-chip.active {
            background: var(--uaemex-green);
            color: white;
            border-color: var(--uaemex-green);
        }

        .table-wrapper {
            overflow-x: auto;
            margin: -1.75rem;
            padding: 1.75rem;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead th {
            text-align: left;
            padding: 1rem;
            font-weight: 600;
            color: var(--gray-600);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--gray-200);
            background: var(--gray-50);
        }

        .data-table tbody td {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid var(--gray-200);
            vertical-align: middle;
        }

        .data-table tbody tr {
            transition: all 0.2s;
        }

        .data-table tbody tr:hover {
            background: var(--gray-50);
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-cell-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--uaemex-green) 0%, var(--uaemex-gold) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .user-cell-info h4 {
            font-weight: 600;
            font-size: 0.9375rem;
            margin-bottom: 0.25rem;
            color: var(--gray-900);
        }

        .user-cell-info p {
            font-size: 0.875rem;
            color: var(--gray-500);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8125rem;
            font-weight: 600;
            gap: 0.375rem;
        }

        .badge.admin {
            background: rgba(139, 92, 246, 0.1);
            color: #7C3AED;
        }

        .badge.editor {
            background: rgba(37, 99, 235, 0.1);
            color: #2563EB;
        }

        .metric-value {
            font-weight: 700;
            font-size: 1.125rem;
            color: var(--gray-900);
        }

        .metric-label {
            font-size: 0.875rem;
            color: var(--gray-500);
            font-weight: 500;
        }

        .progress-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .progress-bar {
            flex: 1;
            height: 8px;
            background: var(--gray-200);
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--uaemex-green) 0%, var(--uaemex-gold) 100%);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .progress-percentage {
            font-weight: 700;
            font-size: 0.875rem;
            color: var(--gray-700);
            min-width: 45px;
            text-align: right;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .activity-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .activity-item:hover {
            background: var(--gray-50);
            border-color: var(--gray-200);
        }

        .activity-icon-wrapper {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.25rem;
        }

        .activity-icon-wrapper.auth {
            background: rgba(37, 99, 235, 0.1);
        }

        .activity-icon-wrapper.survey {
            background: rgba(5, 150, 105, 0.1);
        }

        .activity-icon-wrapper.user {
            background: rgba(217, 119, 6, 0.1);
        }

        .activity-icon-wrapper.approval {
            background: rgba(139, 92, 246, 0.1);
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            font-size: 0.9375rem;
            margin-bottom: 0.25rem;
            color: var(--gray-900);
        }

        .activity-description {
            font-size: 0.875rem;
            color: var(--gray-500);
            line-height: 1.5;
        }

        .activity-time {
            font-size: 0.8125rem;
            color: var(--gray-400);
            font-weight: 500;
            white-space: nowrap;
        }

        .chart-container {
            height: 320px;
            background: var(--gray-50);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed var(--gray-300);
            color: var(--gray-400);
        }

        .chart-placeholder-content {
            text-align: center;
        }

        .chart-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .alert-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--danger);
            margin-bottom: 1rem;
        }

        .alert-header {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .alert-icon {
            width: 40px;
            height: 40px;
            background: rgba(220, 38, 38, 0.1);
            color: var(--danger);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .alert-content h4 {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--gray-900);
        }

        .alert-content p {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        @media (max-width: 1200px) {
            .content-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .main-wrapper {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-title-row {
                flex-direction: column;
                gap: 1rem;
            }

            .header-left {
                gap: 1rem;
            }

            .system-status {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="top-header">
        <div class="header-left">
            <div class="university-brand">
                <div class="university-shield">🎓</div>
                <div class="brand-text">
                    <h1>SIEI - UAEMex</h1>
                    <p>Sistema Integral de Encuestas Institucionales</p>
                </div>
            </div>
            <div class="system-status">
                <span class="status-indicator"></span>
                <span>Sistema operando</span>
            </div>
        </div>
        <div class="header-right">
            <div class="header-icon-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="notification-dot"></span>
            </div>
            <div class="header-icon-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div class="user-profile">
                <div class="user-avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">
                        @switch(Auth::user()->role)
                            @case('admin') Administrador @break
                            @case('editor') Editor @break
                            @default Usuario
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </header>

    <nav class="navigation-bar">
        <div class="nav-tabs">
            <a href="{{ route('dashboard') }}"
               class="nav-tab {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Panel de Control
            </a>
            <a href="{{ route('surveys.index') }}"
               class="nav-tab {{ request()->routeIs('surveys.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Encuestas Globales
            </a>
            <a href="{{ route('users.index') }}"
               class="nav-tab {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Usuarios
            </a>
            <a href="{{ route('admin.aprobaciones') }}"
               class="nav-tab {{ request()->routeIs('admin.aprobaciones') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Aprobaciones
                <span class="tab-badge">3</span>
            </a>
            <a href="{{ route('statistics.index') }}"
               class="nav-tab {{ request()->routeIs('statistics.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Estadísticas
            </a>
            <a href="{{ route('activity-logs.index') }}"
               class="nav-tab {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Bitácora
            </a>
        </div>
    </nav>

    <main class="main-wrapper">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>

