@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --pitch-green: #00f593;
            --pitch-green-dim: rgba(0, 245, 147, 0.15);
            --pitch-green-glow: rgba(0, 245, 147, 0.4);
            --floodlight-amber: #ffb400;
            --floodlight-glow: rgba(255, 180, 0, 0.35);
            --stadium-bg: #0b0f1c;
            --card-bg: rgba(18, 24, 47, 0.85);
            --card-border: rgba(255, 255, 255, 0.06);
            --card-hover-border: rgba(0, 245, 147, 0.25);
            --text-primary: #f0f4ff;
            --text-secondary: rgba(240, 244, 255, 0.55);
            --text-muted: rgba(240, 244, 255, 0.3);
            --danger: #ff4466;
            --danger-bg: rgba(255, 68, 102, 0.12);
            --warning-bg: rgba(255, 180, 0, 0.12);
            --success-bg: rgba(0, 245, 147, 0.12);
            --radius: 16px;
            --radius-sm: 10px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--stadium-bg) !important;
            color: var(--text-primary);
            
        }

        .horarios-page {
            padding: 32px;
            max-width: 1280px;
            margin: 0 auto;
            position: relative;
            min-height: 100vh;
        }

        /* === PITCH TEXTURE OVERLAY === */
        .horarios-page::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 60px,
                    rgba(0, 245, 147, 0.015) 60px,
                    rgba(0, 245, 147, 0.015) 61px
                ),
                repeating-linear-gradient(
                    90deg,
                    transparent,
                    transparent 60px,
                    rgba(0, 245, 147, 0.015) 60px,
                    rgba(0, 245, 147, 0.015) 61px
                );
            pointer-events: none;
            z-index: 0;
        }

        /* === HEADER === */
        .page-header {
            position: relative;
            z-index: 1;
            margin-bottom: 36px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-header-left {
            display: flex;
            flex-direction: column;
        }

        .page-header h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3.2rem;
            font-weight: 400;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-primary);
            margin: 0;
            line-height: 1;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header h1 i {
            color: var(--pitch-green);
            font-size: 2.4rem;
        }

        .page-header .subtitle {
            font-size: 0.95rem;
            color: var(--text-secondary);
            margin: 8px 0 0;
            font-weight: 300;
            letter-spacing: 0.3px;
        }

        .header-accent {
            display: inline-block;
            width: 48px;
            height: 3px;
            background: var(--pitch-green);
            border-radius: 4px;
            margin-top: 8px;
            box-shadow: 0 0 20px var(--pitch-green-glow);
        }

        .live-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 400;
            background: rgba(255, 255, 255, 0.04);
            padding: 8px 16px;
            border-radius: 100px;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .live-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--pitch-green);
            animation: pulse-dot 1.6s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); box-shadow: 0 0 0 0 var(--pitch-green-glow); }
            50% { opacity: 0.6; transform: scale(0.9); box-shadow: 0 0 12px 4px var(--pitch-green-glow); }
        }

        /* === ALERTS === */
        .alert {
            position: relative;
            z-index: 1;
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            font-size: 0.9rem;
            font-weight: 400;
            border: 1px solid transparent;
            backdrop-filter: blur(8px);
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--pitch-green);
            border-color: rgba(0, 245, 147, 0.15);
        }

        .alert-danger {
            background: var(--danger-bg);
            color: var(--danger);
            border-color: rgba(255, 68, 102, 0.15);
        }

        .alert-danger ul {
            margin: 0;
            list-style: none;
            padding: 0;
        }

        /* === FILTER BAR === */
        .filter-bar {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 32px;
            flex-wrap: wrap;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: var(--radius);
            padding: 16px 20px;
            backdrop-filter: blur(8px);
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 0;
        }

        .filter-group label {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .filter-bar .date-input {
            flex: 1;
            min-width: 160px;
            padding: 10px 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-family: 'Outfit', sans-serif;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-primary);
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .filter-bar .date-input:focus {
            outline: none;
            border-color: var(--pitch-green);
            box-shadow: 0 0 0 3px var(--pitch-green-dim);
        }

        .filter-bar .date-input::placeholder {
            color: var(--text-muted);
        }

        .flatpickr-calendar {
            background: #12182f !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: var(--radius-sm) !important;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.5) !important;
        }

        .flatpickr-months .flatpickr-month,
        .flatpickr-current-month .flatpickr-monthDropdown-months,
        span.flatpickr-weekday {
            color: var(--text-primary) !important;
        }

        .flatpickr-day {
            color: var(--text-secondary) !important;
        }

        .flatpickr-day.today {
            border-color: var(--pitch-green) !important;
        }

        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange,
        .flatpickr-day.inRange {
            background: var(--pitch-green) !important;
            border-color: var(--pitch-green) !important;
            color: #0b0f1c !important;
        }

        .filter-bar .status-filter {
            padding: 10px 36px 10px 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-family: 'Outfit', sans-serif;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-primary);
            min-width: 150px;
            cursor: pointer;
            transition: border-color 0.25s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='rgba(240,244,255,0.5)' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
        }

        .filter-bar .status-filter:focus {
            outline: none;
            border-color: var(--pitch-green);
            box-shadow: 0 0 0 3px var(--pitch-green-dim);
        }

        .filter-bar .status-filter option {
            background: #12182f;
            color: var(--text-primary);
        }

        .btn-filter {
            background: var(--pitch-green);
            color: #0b0f1c;
            border: none;
            padding: 10px 24px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.85rem;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-filter:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px var(--pitch-green-glow);
        }

        .btn-filter:active {
            transform: translateY(0);
        }

        /* === GRID === */
        .horarios-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        /* === CARD === */
        .hora-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            padding: 24px 18px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(12px);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1),
                        border-color 0.3s,
                        box-shadow 0.4s;
            animation: card-enter 0.5s ease-out backwards;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .hora-card:nth-child(1) { animation-delay: 0.02s; }
        .hora-card:nth-child(2) { animation-delay: 0.06s; }
        .hora-card:nth-child(3) { animation-delay: 0.10s; }
        .hora-card:nth-child(4) { animation-delay: 0.14s; }
        .hora-card:nth-child(5) { animation-delay: 0.18s; }
        .hora-card:nth-child(6) { animation-delay: 0.22s; }
        .hora-card:nth-child(7) { animation-delay: 0.26s; }
        .hora-card:nth-child(8) { animation-delay: 0.30s; }
        .hora-card:nth-child(9) { animation-delay: 0.34s; }
        .hora-card:nth-child(10) { animation-delay: 0.38s; }
        .hora-card:nth-child(11) { animation-delay: 0.42s; }
        .hora-card:nth-child(12) { animation-delay: 0.46s; }
        .hora-card:nth-child(13) { animation-delay: 0.50s; }
        .hora-card:nth-child(14) { animation-delay: 0.54s; }
        .hora-card:nth-child(15) { animation-delay: 0.58s; }
        .hora-card:nth-child(16) { animation-delay: 0.62s; }

        @keyframes card-enter {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .hora-card.disponible {
            cursor: pointer;
        }

        .hora-card.disponible:hover {
            transform: translateY(-6px) scale(1.02);
            border-color: var(--card-hover-border);
            box-shadow: 0 12px 40px rgba(0, 245, 147, 0.12),
                        0 0 60px rgba(0, 245, 147, 0.04);
        }

        .hora-card.disponible:active {
            transform: translateY(-2px) scale(1.01);
        }

        .hora-card.no-disponible {
            opacity: 0.5;
            cursor: default;
        }

        .hora-card.no-disponible:hover {
            border-color: rgba(255, 68, 102, 0.2);
        }

        /* Gradient top bar */
        .hora-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .hora-card.disponible::before {
            background: linear-gradient(90deg, var(--pitch-green), #00c97a);
            box-shadow: 0 0 16px var(--pitch-green-glow);
        }

        .hora-card.no-disponible::before {
            background: linear-gradient(90deg, var(--danger), #ff6688);
        }

        /* Glow orb on available cards */
        .hora-card.disponible::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(0, 245, 147, 0.04), transparent 70%);
            pointer-events: none;
            transition: opacity 0.4s;
        }

        .hora-card.disponible:hover::after {
            opacity: 0.6;
        }

        .hora-card .hora {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.2rem;
            font-weight: 400;
            letter-spacing: 1.5px;
            color: var(--text-primary);
            line-height: 1;
            position: relative;
            z-index: 1;
        }

        .hora-card .fecha {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 400;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
            margin-bottom: 2px;
        }

        .hora-card .estado-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 12px;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            position: relative;
            z-index: 1;
            margin: 4px 0 10px;
        }

        .hora-card .estado-badge.disponible {
            background: var(--success-bg);
            color: var(--pitch-green);
            border: 1px solid rgba(0, 245, 147, 0.15);
        }

        .hora-card .estado-badge.ocupado,
        .hora-card .estado-badge.no-disponible {
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid rgba(255, 68, 102, 0.15);
        }

        .hora-card .estado-badge.pendiente {
            background: var(--warning-bg);
            color: var(--floodlight-amber);
            border: 1px solid rgba(255, 180, 0, 0.15);
        }

        .hora-card .btn-reservar-card {
            background: var(--pitch-green);
            color: #0b0f1c;
            border: none;
            padding: 10px 0;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.8rem;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            transition: transform 0.25s, box-shadow 0.25s;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            position: relative;
            z-index: 1;
        }

        .hora-card .btn-reservar-card:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 16px var(--pitch-green-glow);
        }

        .hora-card .btn-disabled-card {
            background: rgba(255, 255, 255, 0.04);
            color: var(--text-muted);
            border: 1px solid rgba(255, 255, 255, 0.06);
            padding: 9px 0;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-family: 'Outfit', sans-serif;
            width: 100%;
            cursor: not-allowed;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
        }

        /* === TABLE (desktop fallback) === */
        .horarios-tabla-wrap {
            position: relative;
            z-index: 1;
        }

        .horarios-tabla {
            width: 100%;
            border-collapse: collapse;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            overflow: hidden;
            backdrop-filter: blur(12px);
        }

        .horarios-tabla th {
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.02);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .horarios-tabla td {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            vertical-align: middle;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .horarios-tabla tr:last-child td {
            border-bottom: none;
        }

        .horarios-tabla tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        .estado {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 14px;
            border-radius: 100px;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .estado.disponible {
            background: var(--success-bg);
            color: var(--pitch-green);
            border: 1px solid rgba(0, 245, 147, 0.12);
        }

        .estado.ocupado,
        .estado.no-disponible {
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid rgba(255, 68, 102, 0.12);
        }

        .estado.esperando {
            background: var(--warning-bg);
            color: var(--floodlight-amber);
            border: 1px solid rgba(255, 180, 0, 0.12);
        }

        .btn-reservar {
            background: var(--pitch-green);
            color: #0b0f1c;
            border: none;
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.8rem;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-reservar:hover {
            transform: scale(1.04);
            box-shadow: 0 4px 16px var(--pitch-green-glow);
        }

        .btn-disabled {
            background: rgba(255, 255, 255, 0.04);
            color: var(--text-muted);
            border: 1px solid rgba(255, 255, 255, 0.06);
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            cursor: not-allowed;
            font-size: 0.8rem;
        }

        .btn-group {
            display: inline-flex;
            gap: 6px;
            margin-left: 10px;
        }

        .btn-group .btn {
            padding: 5px 12px;
            font-size: 0.75rem;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
            font-family: 'Outfit', sans-serif;
        }

        .btn-group .btn-warning {
            background: var(--floodlight-amber);
            color: #0b0f1c;
        }

        .btn-group .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-group .btn:hover {
            opacity: 0.85;
        }

        /* === EMPTY STATE === */
        .empty-state {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 80px 20px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            backdrop-filter: blur(12px);
        }

        .empty-state i {
            font-size: 64px;
            color: var(--text-muted);
            margin-bottom: 16px;
        }

        .empty-state p {
            font-size: 1.1rem;
            color: var(--text-secondary);
        }

        /* === PAGINATION === */
        .pagination-wrap {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            margin-top: 24px;
        }

        .pagination {
            display: flex;
            gap: 6px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-family: 'Outfit', sans-serif;
            text-decoration: none;
            transition: border-color 0.2s, background 0.2s, color 0.2s;
            backdrop-filter: blur(8px);
        }

        .pagination .page-item .page-link:hover {
            border-color: var(--pitch-green);
            color: var(--pitch-green);
            background: var(--pitch-green-dim);
        }

        .pagination .page-item.active .page-link {
            background: var(--pitch-green);
            border-color: var(--pitch-green);
            color: #0b0f1c;
            font-weight: 700;
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.3;
            cursor: not-allowed;
        }

        /* === MODAL === */
        .modal-content {
            background: #12182f !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: var(--radius) !important;
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.6) !important;
            backdrop-filter: blur(20px);
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
            padding: 20px 24px 16px !important;
        }

        .modal-header .modal-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.6rem;
            letter-spacing: 1px;
            color: var(--text-primary);
        }

        .modal-header .btn-close {
            filter: invert(1) brightness(200%);
            opacity: 0.5;
        }

        .modal-body {
            padding: 24px !important;
        }

        .modal-body .modal-icon {
            font-size: 3.6rem;
            color: var(--pitch-green);
            margin-bottom: 12px;
        }

        #modalText {
            font-size: 1.05rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        #modalText strong {
            color: var(--text-primary);
        }

        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
            padding: 16px 24px 20px !important;
            gap: 10px;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.06) !important;
            color: var(--text-secondary) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            padding: 10px 22px !important;
            border-radius: var(--radius-sm) !important;
            font-weight: 600 !important;
            font-family: 'Outfit', sans-serif !important;
            transition: background 0.2s !important;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1) !important;
        }

        .btn-primary {
            background: var(--pitch-green) !important;
            color: #0b0f1c !important;
            border: none !important;
            padding: 10px 28px !important;
            border-radius: var(--radius-sm) !important;
            font-weight: 700 !important;
            font-family: 'Outfit', sans-serif !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            transition: transform 0.2s, box-shadow 0.2s !important;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px var(--pitch-green-glow);
        }

        /* === RESPONSIVE === */
        @media (min-width: 769px) {
            .horarios-grid {
                display: grid;
            }
        }

        @media (max-width: 768px) {
            .horarios-tabla-wrap {
                display: none;
            }

            .horarios-page {
                padding: 16px;
            }

            .page-header h1 {
                font-size: 2.2rem;
            }

            .page-header h1 i {
                font-size: 1.8rem;
            }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
                padding: 14px 16px;
            }

            .filter-group {
                flex-direction: column;
                align-items: stretch;
                gap: 6px;
            }

            .filter-bar .date-input,
            .filter-bar .status-filter {
                min-width: unset;
            }

            .horarios-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 12px;
            }
        }

        @media (max-width: 400px) {
            .horarios-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .hora-card {
                padding: 16px 12px 16px;
            }

            .hora-card .hora {
                font-size: 1.6rem;
            }
        }
    </style>
@endpush

@section('main')
<div style="background-color: #12182f;" class="horarios-page">
    <div class="page-header">
        <div class="page-header-left">
            <h1>
                <i class='bx bx-football'></i>
                Horarios
            </h1>
            <p class="subtitle">Selecciona tu horario y asegura tu partido</p>
            <span class="header-accent"></span>
        </div>
        <div class="live-indicator">
            <span class="live-dot"></span>
            <span>{{ $horarios->where('estado', 'Disponible')->count() }} disponibles hoy</span>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="filter-bar">
        <div class="filter-group">
            <label>Fecha</label>
            <input type="text" id="dateFilter" class="date-input" placeholder="Filtrar por fecha..." autocomplete="off">
        </div>
        <div class="filter-group">
            <label>Estado</label>
            <select id="statusFilter" class="status-filter">
                <option value="">Todos</option>
                <option value="Disponible">Disponibles</option>
                <option value="No Disponible">No disponibles</option>
            </select>
        </div>
        <button class="btn-filter" onclick="applyFilters()">Filtrar</button>
    </div>

    @if($horarios->isEmpty())
    <div class="empty-state">
        <i class='bx bx-calendar-x'></i>
        <p>No existen horarios disponibles</p>
    </div>
    @else
    <div class="horarios-grid" id="horariosGrid">
        @foreach($horarios as $horario)
        <div class="hora-card {{ strtolower(str_replace(' ', '-', $horario->estado)) }}"
        data-fecha="{{ $horario->fecha }}"
        data-estado="{{ $horario->estado }}">
        <div class="hora">{{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}</div>
        <div class="fecha">{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}</div>
        <span class="estado-badge {{ strtolower(str_replace(' ', '-', $horario->estado)) }}">
            <i class='bx {{ $horario->estado == 'Disponible' ? 'bx-check-circle' : 'bx-x-circle' }}'></i>
            {{ $horario->estado == 'Disponible' ? 'Disponible' : 'Reservado' }}
        </span>
        @auth
        @if($horario->estado == 'Disponible')
        <button class="btn-reservar-card" onclick="openReservaModal({{ $horario->id }}, '{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}', '{{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}')">
            Reservar
        </button>
        @else
        <button class="btn-disabled-card" disabled>No disponible</button>
        @endif
        @else
        <button class="btn-reservar-card" onclick="alert('Debes iniciar sesión para reservar.')">Reservar</button>
        @endauth
    </div>
    @endforeach
</div>

<div class="horarios-tabla-wrap">
    <table class="horarios-tabla" id="horariosTable">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horarios as $horario)
            <tr data-fecha="{{ $horario->fecha }}" data-estado="{{ $horario->estado }}">
                <td>{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}</td>
                <td><strong>{{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}</strong></td>
                <td>
                    @if($horario->reserva)
                    <span class="estado ocupado"><i class='bx bx-x-circle'></i> Reservada</span>
                    @elseif($horario->estado == 'Disponible')
                    <span class="estado disponible"><i class='bx bx-check-circle'></i> Disponible</span>
                    @else
                    <span class="estado esperando"><i class='bx bx-time'></i> Esperando</span>
                    @endif
                </td>
                <td>
                    @if($horario->estado == 'Disponible')
                    @auth
                    <button class="btn-reservar"
                    onclick="openReservaModal({{ $horario->id }}, '{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}', '{{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}')">
                    Reservar
                </button>
                @else
                <button class="btn-reservar" onclick="alert('Debes iniciar sesión para realizar una reserva.');">Reservar</button>
                @endauth
                @else
                <button class="btn-disabled" disabled>No disponible</button>
                @endif
                @can('crear horarios')
                <div class="btn-group">
                    <a href="{{ route('horarios.edit', $horario) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('horarios.destroy', $horario) }}" method="POST" style="display:inline" onsubmit="event.preventDefault(); confirmarEliminacion(this);">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<div class="pagination-wrap">
    {{ $horarios->links('pagination::bootstrap-5') }}
</div>
@endif
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-confirm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class='bx bx-football' style="color: var(--pitch-green); margin-right: 8px;"></i> Confirmar Reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="modal-icon">
                    <i class='bx bx-calendar-check'></i>
                </div>
                <p id="modalText" style="font-size: 1.05rem; margin: 0;"></p>
            </div>
            <div class="modal-footer justify-content-center">
                <form id="reservaForm" action="{{ route('reservas.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="horario_id" id="modalHorarioId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-check'></i> Confirmar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    flatpickr("#dateFilter", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d/m/Y",
        allowInput: true,
        onChange: function(selectedDates, dateStr) {
            applyFilters();
        }
    });

    function applyFilters() {
        const date = document.getElementById('dateFilter').value;
        const status = document.getElementById('statusFilter').value;

        document.querySelectorAll('#horariosTable tbody tr, .horarios-grid .hora-card').forEach(el => {
            const rowDate = el.dataset.fecha;
            const rowStatus = el.dataset.estado;
            let show = true;

            if (date && rowDate !== date) show = false;
            if (status && rowStatus !== status) show = false;

            el.style.display = show ? '' : 'none';
        });
    }

    function openReservaModal(id, fecha, hora) {
        document.getElementById('modalHorarioId').value = id;
        document.getElementById('modalText').innerHTML =
            `¿Deseas reservar el horario del <strong>${fecha}</strong> a las <strong>${hora}</strong> hrs?`;
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        modal.show();
    }

    function confirmarEliminacion(form) {
        Swal.fire({
            title: '¿Eliminar horario?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff4466',
            cancelButtonColor: 'rgba(255,255,255,0.08)',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#12182f',
            color: '#f0f4ff',
            iconColor: '#ff4466'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() { alert.remove(); }, 500);
            }, 5000);
        });
    });
</script>
@endpush
@endsection
