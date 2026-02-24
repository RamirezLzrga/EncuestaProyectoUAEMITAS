<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIEI UAEMex - @yield('title', 'Panel Administrativo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --uaemex-green: #1a5c2a;
            --uaemex-green-dark: #12411d;
            --uaemex-green-light: #2a7b3d;
            --uaemex-gold: #c9a227;
            --uaemex-gold-dark: #a8861e;
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

        .bg-uaemex {
            background-color: var(--uaemex-green);
        }

        .text-uaemex {
            color: var(--uaemex-green);
        }

        .border-uaemex {
            border-color: var(--uaemex-green);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
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
            border-bottom: 2px solid var(--uaemex-gold);
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
            font-family: 'Playfair Display', serif;
            font-size: 1.125rem;
            font-weight: 600;
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

        .user-avatar-btn {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.45);
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-avatar-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
        }

        .user-dropdown {
            position: absolute;
            right: 0;
            top: 52px;
            min-width: 220px;
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--gray-200);
            padding: 0.75rem 0.75rem 0.75rem;
            z-index: 1100;
        }

        .user-dropdown-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--gray-100);
            margin-bottom: 0.5rem;
        }

        .user-dropdown-avatar {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            background: var(--uaemex-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.82rem;
            color: white;
        }

        .user-dropdown-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--gray-900);
        }

        .user-dropdown-role {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.125rem 0.5rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--gray-200);
            color: var(--gray-700);
            margin-top: 0.15rem;
        }

        .user-dropdown-footer {
            padding-top: 0.5rem;
            display: flex;
            justify-content: flex-end;
        }

        .btn-logout-admin {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.85rem;
            border-radius: 999px;
            border: 1px solid var(--gray-300);
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--gray-700);
            background: white;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-logout-admin:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
        }

        .admin-layout {
            display: flex;
        }

        .navigation-bar {
            background: var(--uaemex-green);
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: var(--shadow-sm);
            position: fixed;
            top: 72px;
            left: 0;
            bottom: 0;
            width: 240px;
            z-index: 999;
            display: flex;
            flex-direction: column;
            padding: 1.25rem 0.75rem;
        }

        .nav-tabs {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            overflow-y: auto;
            padding-right: 0.25rem;
        }

        .nav-tab {
            padding: 0.7rem 1.1rem;
            margin: 0 0.25rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            border-radius: 999px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .nav-tab svg {
            flex-shrink: 0;
        }

        .nav-tab:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-tab.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
            font-weight: 600;
            border-left: 3px solid var(--uaemex-gold);
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
            margin-left: 260px;
            font-size: 0.875rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--gray-900);
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
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
            border-radius: 0.75rem;
            border: 1px solid transparent;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9375rem;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--uaemex-green);
            color: #ffffff;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .btn-primary:hover {
            background: var(--uaemex-green-dark);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: transparent;
            color: var(--uaemex-green);
            border-color: var(--uaemex-green);
        }

        .btn-secondary:hover {
            background: rgba(26, 92, 42, 0.06);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--uaemex-gold) 0%, var(--uaemex-gold-dark) 100%);
            color: #ffffff;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
        }

        .btn-gold:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.16);
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
            border-radius: 0.75rem;
            padding: 1.75rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
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

        .data-table thead tr {
            background: rgba(26, 92, 42, 0.04);
        }

        .data-table thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .data-table tbody tr:hover {
            background: rgba(15, 23, 42, 0.02);
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
                padding: 1.5rem 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-title-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
                margin-bottom: 1rem;
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
                <div class="university-shield" style="background: transparent; padding: 0;">
                    <img src="https://ri.uaemex.mx/bitstream/handle/20.500.11799/66757/positivo%20color%20vertical%202%20li%cc%81neas.png?sequence=1&isAllowed=y" alt="UAEMex Logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
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
            <div style="position: relative;">
                <button id="adminUserBtn" class="user-avatar-btn">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </button>
                <div id="adminUserDropdown" class="user-dropdown hidden">
                    <div class="user-dropdown-header">
                        <div class="user-dropdown-avatar">
                            @php $avatarUrl = Auth::user()->avatar_url ?? null; @endphp
                            @if($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="Foto de perfil" style="width:100%;height:100%;border-radius:999px;object-fit:cover;">
                            @else
                                {{ substr(Auth::user()->name, 0, 2) }}
                            @endif
                        </div>
                        <div>
                            <div class="user-dropdown-name">{{ Auth::user()->name }}</div>
                            <div class="user-dropdown-role">
                                @switch(Auth::user()->role)
                                    @case('admin') Administrador @break
                                    @case('editor') Editor @break
                                    @default Usuario
                                @endswitch
                            </div>
                        </div>
                    </div>
                    <div class="user-dropdown-footer" style="display:flex;flex-direction:column;gap:0.5rem;">
                        <a href="{{ route('profile.show') }}" class="btn-logout-admin" style="justify-content:flex-start;">
                            <i class="fas fa-user-cog"></i>
                            Mi perfil
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-logout-admin">
                                <i class="fas fa-sign-out-alt"></i>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="admin-layout">
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const adminUserBtn = document.getElementById('adminUserBtn');
            const adminUserDropdown = document.getElementById('adminUserDropdown');

            if (adminUserBtn && adminUserDropdown) {
                adminUserBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    adminUserDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function (e) {
                    if (!adminUserBtn.contains(e.target) && !adminUserDropdown.contains(e.target)) {
                        adminUserDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
    <script>
        if (window.Chart) {
            Chart.defaults.font.family = 'Inter, system-ui, -apple-system, BlinkMacSystemFont, sans-serif';
            Chart.defaults.color = '#374151';
            if (Chart.defaults.plugins && Chart.defaults.plugins.tooltip) {
                Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(26, 92, 42, 0.96)';
                Chart.defaults.plugins.tooltip.titleColor = '#ffffff';
                Chart.defaults.plugins.tooltip.bodyColor = '#f9fafb';
                Chart.defaults.plugins.tooltip.borderColor = 'rgba(201, 162, 39, 0.6)';
                Chart.defaults.plugins.tooltip.borderWidth = 1;
            }
        }
    </script>
</body>
</html>
