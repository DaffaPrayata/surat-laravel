@extends('layout.main')

@push('style')
    <link rel="stylesheet" href="{{ asset('sneat/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════
           TOKEN SYSTEM — light & dark
        ══════════════════════════════════════ */
        :root {
            --bg-page:        #f0f4fa;
            --bg-surface:     #ffffff;
            --bg-navy:        #0c1220;
            --bg-navy-sub:    #111827;
            --border:         rgba(0,0,0,.07);
            --border-navy:    #1e2d45;
            --text-primary:   #0c1220;
            --text-secondary: #64748b;
            --text-hint:      #94a3b8;
            --text-navy:      #e8f0fe;
            --text-navy-dim:  #5a7a9a;
            --text-accent:    #7eb8f7;
            --emerald:        #1D9E75;
            --emerald-dim:    #E1F5EE;
            --radius:         14px;
            --radius-sm:      8px;
            --shadow:         0 1px 3px rgba(0,0,0,.06);
        }

        [data-theme="dark"] {
            --bg-page:        #0d1117;
            --bg-surface:     #161c28;
            --bg-navy:        #0d1117;
            --bg-navy-sub:    #161c28;
            --border:         rgba(255,255,255,.07);
            --text-primary:   #e8f0fe;
            --text-secondary: #8b9ab8;
            --text-hint:      #4a6080;
            --shadow:         0 1px 3px rgba(0,0,0,.3);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', system-ui, sans-serif;
            background: var(--bg-page);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
        }

        /* ══════════════════════════════════════
           TOP BAR
        ══════════════════════════════════════ */
        .db-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 12px;
        }

        .db-page-title {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1;
        }

        .db-page-sub {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            color: var(--text-secondary);
            margin-top: 3px;
        }

        .theme-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px 6px 10px;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 100px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-primary);
            white-space: nowrap;
            box-shadow: var(--shadow);
        }
        .theme-pill i { font-size: 14px; }

        /* ══════════════════════════════════════
           DESKTOP LAYOUT
        ══════════════════════════════════════ */
        .desktop-view { display: block; }
        .mobile-view  { display: none; }

        .db-grid {
            display: grid;
            grid-template-columns: 1fr 288px;
            gap: 16px;
            align-items: start;
        }

        .db-col { display: flex; flex-direction: column; gap: 14px; }

        /* ── Welcome card ── */
        .welcome-card {
            background: var(--bg-navy);
            border: 1px solid var(--border-navy);
            border-radius: var(--radius);
            padding: 22px 22px 0;
            overflow: hidden;
        }

        .welcome-eyebrow { display:flex; align-items:center; gap:6px; margin-bottom:10px; }
        .welcome-dot { width:6px; height:6px; border-radius:50%; background:#5DCAA5; flex-shrink:0; }
        .welcome-date {
            font-family: 'DM Mono', monospace;
            font-size: 11px; color: var(--text-navy-dim);
            letter-spacing: .08em; text-transform: uppercase;
        }
        .welcome-name {
            font-family: 'Syne', sans-serif;
            font-size: 22px; font-weight: 800;
            color: var(--text-navy); line-height: 1.15; margin-bottom: 5px;
        }
        .welcome-sub { font-size: 13px; color: var(--text-navy-dim); margin-bottom: 20px; }

        .welcome-strip {
            display: grid; grid-template-columns: repeat(3, 1fr);
            border-top: 1px solid var(--border-navy); margin: 0 -22px;
        }
        .ws-cell { padding:14px 10px; text-align:center; position:relative; }
        .ws-cell + .ws-cell::before {
            content:''; position:absolute; left:0; top:20%; bottom:20%;
            width:1px; background:var(--border-navy);
        }
        .ws-num {
            font-family: 'Syne', sans-serif; font-size:22px; font-weight:800;
            color: var(--text-accent); line-height:1;
        }
        .ws-lbl {
            font-family: 'DM Mono', monospace; font-size:9px;
            color: var(--text-navy-dim); letter-spacing:.06em;
            text-transform:uppercase; margin-top:4px; line-height:1.3;
        }

        /* ── Chart card ── */
        .chart-card {
            background: var(--bg-surface); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 20px 20px 8px; box-shadow: var(--shadow);
        }
        .chart-head {
            display:flex; justify-content:space-between; align-items:flex-start;
            margin-bottom:6px; gap:8px;
        }
        .chart-title {
            font-family: 'Syne', sans-serif; font-size:15px; font-weight:700;
            color: var(--text-primary); margin-bottom:2px;
        }
        .chart-sub  { font-family:'DM Mono',monospace; font-size:11px; color:var(--text-hint); }
        .chart-right { text-align:right; flex-shrink:0; }
        .chart-total {
            font-family: 'Syne', sans-serif; font-size:26px; font-weight:800;
            color: var(--text-primary); line-height:1;
        }
        .chart-total-lbl {
            font-family: 'DM Mono', monospace; font-size:10px;
            color: var(--text-hint); letter-spacing:.07em; text-transform:uppercase; margin-top:2px;
        }

        .trend-badge {
            display:inline-flex; align-items:center; gap:3px;
            font-family:'DM Mono',monospace; font-size:11px; font-weight:500;
            padding:3px 8px; border-radius:4px; margin-bottom:5px;
        }
        .trend-badge.up   { color:#085041; background:#9FE1CB; }
        .trend-badge.down { color:#712B13; background:#F5C4B3; }
        .trend-badge svg  { width:10px; height:10px; stroke:currentColor; stroke-width:2.5; fill:none; stroke-linecap:round; stroke-linejoin:round; }

        /* ── Stat cards ── */
        .stat-card {
            background: var(--bg-surface); border:1px solid var(--border);
            border-radius: var(--radius); padding:16px 18px; box-shadow:var(--shadow);
        }
        .stat-top { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px; }
        .stat-icon { width:36px; height:36px; border-radius:var(--radius-sm); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .stat-icon svg { width:16px; height:16px; fill:none; stroke-width:1.5; stroke-linecap:round; stroke-linejoin:round; }

        .stat-icon.teal  { background:#E1F5EE; } .stat-icon.teal  svg { stroke:#0F6E56; }
        .stat-icon.coral { background:#FAECE7; } .stat-icon.coral svg { stroke:#993C1D; }
        .stat-icon.blue  { background:#E6F1FB; } .stat-icon.blue  svg { stroke:#185FA5; }
        .stat-icon.amber { background:#FAEEDA; } .stat-icon.amber svg { stroke:#854F0B; }

        [data-theme="dark"] .stat-icon.teal  { background:rgba(29,158,117,.15); }
        [data-theme="dark"] .stat-icon.coral { background:rgba(216,90,48,.15);  }
        [data-theme="dark"] .stat-icon.blue  { background:rgba(55,138,221,.15); }
        [data-theme="dark"] .stat-icon.amber { background:rgba(186,117,23,.15); }

        .stat-badge { font-family:'DM Mono',monospace; font-size:10px; font-weight:500; padding:3px 8px; border-radius:4px; letter-spacing:.03em; }
        .stat-badge.up   { color:#085041; background:#9FE1CB; }
        .stat-badge.down { color:#712B13; background:#F5C4B3; }
        .stat-badge.flat { color:#5F5E5A; background:#F1EFE8; }
        .stat-badge.info { color:#3B6D11; background:#EAF3DE; }
        [data-theme="dark"] .stat-badge.flat { color:#c8d0d8; background:#2a3040; }
        [data-theme="dark"] .stat-badge.info { color:#86efac; background:#14311f; }

        .stat-val { font-family:'Syne',sans-serif; font-size:30px; font-weight:800; color:var(--text-primary); line-height:1; }
        .stat-lbl { font-family:'DM Mono',monospace; font-size:10px; color:var(--text-hint); text-transform:uppercase; letter-spacing:.07em; margin-top:4px; }
        .stat-divider { height:1px; background:var(--border); margin:12px 0 10px; }
        .stat-sub { font-size:12px; color:var(--text-secondary); }

        /* ══════════════════════════════════════
           MOBILE LAYOUT
        ══════════════════════════════════════ */
        .mob-section { margin-bottom: 16px; }

        .mob-section-title {
            font-family: 'DM Mono', monospace;
            font-size: 9px; font-weight: 500;
            color: var(--text-hint);
            text-transform: uppercase; letter-spacing: .1em;
            margin-bottom: 8px;
        }

        /* Quick actions */
        .quick-actions { display:grid; grid-template-columns:1fr 1fr; gap:10px; }

        .qa-card {
            display:flex; flex-direction:column; align-items:flex-start;
            gap:10px; padding:16px 14px; border-radius:var(--radius);
            text-decoration:none; border:1px solid transparent;
        }
        .qa-card.incoming  { background:var(--bg-navy); border-color:var(--border-navy); }
        .qa-card.outgoing  { background:var(--emerald-dim); border-color:rgba(29,158,117,.2); }
        [data-theme="dark"] .qa-card.outgoing { background:rgba(29,158,117,.12); border-color:rgba(29,158,117,.25); }

        .qa-icon { width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; }
        .qa-card.incoming .qa-icon { background:rgba(126,184,247,.15); }
        .qa-card.outgoing .qa-icon { background:rgba(29,158,117,.2); }
        .qa-icon svg { width:18px; height:18px; fill:none; stroke-width:1.5; stroke-linecap:round; stroke-linejoin:round; }
        .qa-card.incoming .qa-icon svg { stroke:var(--text-accent); }
        .qa-card.outgoing .qa-icon svg { stroke:var(--emerald); }

        .qa-label { font-family:'Syne',sans-serif; font-size:13px; font-weight:700; line-height:1.2; }
        .qa-card.incoming .qa-label { color:var(--text-navy); }
        .qa-card.outgoing .qa-label { color:#0F6E56; }
        [data-theme="dark"] .qa-card.outgoing .qa-label { color:#5DCAA5; }

        .qa-sub { font-family:'DM Mono',monospace; font-size:9px; letter-spacing:.06em; text-transform:uppercase; }
        .qa-card.incoming .qa-sub { color:var(--text-navy-dim); }
        .qa-card.outgoing .qa-sub { color:rgba(15,110,86,.6); }
        [data-theme="dark"] .qa-card.outgoing .qa-sub { color:rgba(93,202,165,.5); }

        /* Nav grid */
        .nav-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:8px; }

        .nav-grid-item {
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            gap:6px; padding:14px 8px;
            background:var(--bg-surface); border:1px solid var(--border);
            border-radius:var(--radius); text-decoration:none;
        }

        .ng-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; }
        .ng-icon svg { width:16px; height:16px; fill:none; stroke-width:1.5; stroke-linecap:round; stroke-linejoin:round; }

        .ng-icon.teal  { background:#E1F5EE; } .ng-icon.teal  svg { stroke:#0F6E56; }
        .ng-icon.blue  { background:#E6F1FB; } .ng-icon.blue  svg { stroke:#185FA5; }
        .ng-icon.amber { background:#FAEEDA; } .ng-icon.amber svg { stroke:#854F0B; }
        .ng-icon.coral { background:#FAECE7; } .ng-icon.coral svg { stroke:#993C1D; }
        [data-theme="dark"] .ng-icon.teal  { background:rgba(29,158,117,.15); }
        [data-theme="dark"] .ng-icon.blue  { background:rgba(55,138,221,.15); }
        [data-theme="dark"] .ng-icon.amber { background:rgba(186,117,23,.15); }
        [data-theme="dark"] .ng-icon.coral { background:rgba(216,90,48,.15);  }

        .ng-label {
            font-family:'DM Mono',monospace;
            font-size:9px; font-weight:500;
            color:var(--text-secondary);
            text-transform:uppercase; letter-spacing:.06em;
            text-align:center; line-height:1.3;
        }

        /* Mini stat strip */
        .mob-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:8px; }

        .mob-stat {
            background:var(--bg-surface); border:1px solid var(--border);
            border-radius:var(--radius); padding:12px 10px; text-align:center;
        }
        .mob-stat-num { font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:var(--text-primary); line-height:1; }
        .mob-stat-lbl { font-family:'DM Mono',monospace; font-size:8px; color:var(--text-hint); text-transform:uppercase; letter-spacing:.06em; margin-top:3px; line-height:1.3; }

        /* Activity log */
        .activity-list {
            background:var(--bg-surface); border:1px solid var(--border);
            border-radius:var(--radius); overflow:hidden;
        }

        .act-item {
            display:flex; align-items:center; gap:10px;
            padding:11px 14px; border-bottom:1px solid var(--border);
        }
        .act-item:last-child { border-bottom:none; }

        .act-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; }
        .act-dot.in  { background:#1D9E75; }
        .act-dot.out { background:#D85A30; }

        .act-body { flex:1; min-width:0; }
        .act-number {
            font-family:'DM Mono',monospace; font-size:11px; font-weight:500;
            color:var(--text-primary); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
        }
        .act-sender {
            font-size:11px; color:var(--text-hint);
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-top:1px;
        }
        .act-meta { font-family:'DM Mono',monospace; font-size:9px; color:var(--text-hint); white-space:nowrap; flex-shrink:0; }

        .act-type { font-family:'DM Mono',monospace; font-size:9px; font-weight:500; padding:2px 6px; border-radius:3px; flex-shrink:0; }
        .act-type.in  { color:#085041; background:#9FE1CB; }
        .act-type.out { color:#712B13; background:#F5C4B3; }

        /* Bottom tab bar */
        .bottom-tab {
            position:fixed; bottom:0; left:0; right:0;
            height:56px;
            background:var(--bg-surface); border-top:1px solid var(--border);
            display:flex; align-items:stretch;
            z-index:9999;
            padding-bottom: env(safe-area-inset-bottom);
        }

        .tab-item {
            flex:1; display:flex; flex-direction:column;
            align-items:center; justify-content:center;
            gap:3px; text-decoration:none; color:var(--text-hint);
        }
        .tab-item.active { color:var(--emerald); }
        .tab-item svg { width:20px; height:20px; fill:none; stroke:currentColor; stroke-width:1.8; stroke-linecap:round; stroke-linejoin:round; }
        .tab-label { font-family:'DM Mono',monospace; font-size:8px; font-weight:500; letter-spacing:.04em; text-transform:uppercase; }

        .mob-bottom-spacer { height:72px; }

        /* ══════════════════════════════════════
           BREAKPOINT — ADAPTIVE SWITCH
           FIX: Jangan override transition global
           karena konflik dengan Sneat sidebar toggle.
        ══════════════════════════════════════ */
        @media (min-width: 1200px) {
            .desktop-view { display:block; }
            .mobile-view  { display:none; }
            .bottom-tab   { display:none !important; }
        }

        @media (max-width: 1199.98px) {
            .desktop-view { display:none; }
            .mobile-view  { display:block; }

            /*
             * PENTING: Matikan transition hanya pada elemen dashboard —
             * BUKAN global `*`. Global override akan konflik dengan
             * Sneat sidebar yang pakai transform:translateX untuk toggle.
             */
            .db-topbar, .mob-section,
            .quick-actions, .qa-card,
            .nav-grid, .nav-grid-item,
            .mob-stats, .mob-stat,
            .activity-list, .act-item,
            .stat-card, .chart-card, .welcome-card,
            .bottom-tab, .tab-item, .theme-pill {
                transition: none !important;
                -webkit-transition: none !important;
                box-shadow: none !important;
            }

            body { padding-bottom: 0; }
            .db-topbar { margin-bottom: 14px; }
            .db-page-title { font-size: 16px; }
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('sneat/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script>
        /* ── Theme toggle ── */
        const html        = document.documentElement;
        const themeToggle = document.getElementById('themeToggle');
        const sunIcon     = document.getElementById('sunIcon');
        const moonIcon    = document.getElementById('moonIcon');
        const themeLabel  = document.getElementById('themeLabel');

        const saved = localStorage.getItem('theme') || 'light';
        applyTheme(saved);

        themeToggle.addEventListener('click', () => {
            const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            applyTheme(next);
            localStorage.setItem('theme', next);
            if (typeof chart !== 'undefined' && chart) {
                chart.destroy();
                renderChart();
            }
        });

        function applyTheme(theme) {
            html.setAttribute('data-theme', theme);
            const dark = theme === 'dark';
            sunIcon.style.display  = dark ? 'inline' : 'none';
            moonIcon.style.display = dark ? 'none'   : 'inline';
            themeLabel.textContent = dark ? 'Light'  : 'Dark';
        }

        /* ── Chart (desktop only — tidak dirender di mobile) ── */
        function getPalette() {
            const dark = html.getAttribute('data-theme') === 'dark';
            return dark
                ? { bar:['#5DCAA5','#F0997B','#85B7EB'], label:'#5a7a9a', grid:'#1e2d45' }
                : { bar:['#1D9E75','#D85A30','#378ADD'], label:'#94a3b8', grid:'#edf0f5' };
        }

        let chart;

        function renderChart() {
            const el = document.querySelector('#today-graphic');
            if (!el) return;

            const p      = getPalette();
            const isDark = html.getAttribute('data-theme') === 'dark';

            chart = new ApexCharts(el, {
                chart: {
                    type: 'bar', height: 225,
                    toolbar:    { show: false },
                    background: 'transparent',
                    fontFamily: "'DM Sans', sans-serif",
                    animations: {
                        enabled: true, easing: 'easeOutCubic', speed: 450,
                        animateGradually: { enabled: true, delay: 80 }
                    },
                },
                series: [{
                    name: '{{ __('dashboard.letter_transaction') }}',
                    data: [
                        {{ $todayIncomingLetter }},
                        {{ $todayOutgoingLetter }},
                        {{ $todayDispositionLetter }}
                    ]
                }],
                plotOptions: {
                    bar: {
                        borderRadius: 7,
                        borderRadiusApplication: 'end',
                        columnWidth: '46%',
                        distributed: true,
                        dataLabels: { position: 'top' }
                    }
                },
                colors:  p.bar,
                fill:    { type: 'solid' },
                dataLabels: {
                    enabled: true, offsetY: -20,
                    style: {
                        fontSize: '11px', fontWeight: 600,
                        fontFamily: "'DM Mono', monospace",
                        colors: [p.label]
                    },
                    background: { enabled: false }
                },
                xaxis: {
                    categories: [
                        '{{ __('dashboard.incoming_letter') }}',
                        '{{ __('dashboard.outgoing_letter') }}',
                        '{{ __('dashboard.disposition_letter') }}'
                    ],
                    labels: { style: { colors: p.label, fontSize: '11px', fontFamily: "'DM Mono', monospace" } },
                    axisBorder: { show: false },
                    axisTicks:  { show: false }
                },
                yaxis: {
                    labels: { style: { colors: p.label, fontSize: '11px', fontFamily: "'DM Mono', monospace" } }
                },
                grid: {
                    borderColor: p.grid, strokeDashArray: 4,
                    xaxis: { lines: { show: false } },
                    padding: { top: 8, bottom: 0 }
                },
                legend:  { show: false },
                tooltip: {
                    theme: isDark ? 'dark' : 'light',
                    y: { formatter: v => `${v} surat` }
                },
            });

            chart.render();
        }

        /* Hanya render chart di desktop — hemat resource di mobile */
        if (window.innerWidth >= 1200) {
            renderChart();
        }

        let rsz;
        window.addEventListener('resize', () => {
            clearTimeout(rsz);
            rsz = setTimeout(() => {
                if (window.innerWidth >= 1200 && !chart) {
                    renderChart();
                }
            }, 300);
        });
    </script>
@endpush

{{-- ══════════════════════════════════════════════════════════
     @section('content') — WAJIB ADA, INI YANG SERING HILANG
     Jika section ini tidak ada / salah nama → blank total
══════════════════════════════════════════════════════════ --}}
@section('content')

{{-- ── Top Bar (tampil di semua ukuran) ── --}}
<div class="db-topbar">
    <div>
        <div class="db-page-title">Dashboard</div>
        <div class="db-page-sub">{{ $currentDate }}</div>
    </div>
    <button class="theme-pill" id="themeToggle" type="button">
        <i class='bx bx-sun'  id="sunIcon"  style="display:none"></i>
        <i class='bx bx-moon' id="moonIcon"></i>
        <span id="themeLabel">Dark</span>
    </button>
</div>

{{-- ══════════════════════════════════════
     DESKTOP VIEW ≥ 1200px
══════════════════════════════════════ --}}
<div class="desktop-view">
    <div class="db-grid">

        {{-- Kolom Kiri --}}
        <div class="db-col">

            {{-- Welcome card --}}
            <div class="welcome-card">
                <div class="welcome-eyebrow">
                    <div class="welcome-dot"></div>
                    <div class="welcome-date">{{ $currentDate }}</div>
                </div>
                <div class="welcome-name">{{ $greeting }}</div>
                <div class="welcome-sub">{{ __('dashboard.today_report') }}</div>
                <div class="welcome-strip">
                    <div class="ws-cell">
                        <div class="ws-num">{{ $todayIncomingLetter }}</div>
                        <div class="ws-lbl">{{ __('dashboard.incoming_letter') }}</div>
                    </div>
                    <div class="ws-cell">
                        <div class="ws-num">{{ $todayOutgoingLetter }}</div>
                        <div class="ws-lbl">{{ __('dashboard.outgoing_letter') }}</div>
                    </div>
                    <div class="ws-cell">
                        <div class="ws-num">{{ $todayDispositionLetter }}</div>
                        <div class="ws-lbl">{{ __('dashboard.disposition_letter') }}</div>
                    </div>
                </div>
            </div>

            {{-- Chart --}}
            <div class="chart-card">
                <div class="chart-head">
                    <div>
                        <div class="chart-title">{{ __('dashboard.today_graphic') }}</div>
                        <div class="chart-sub">{{ __('dashboard.today') }}</div>
                    </div>
                    <div class="chart-right">
                        @if($percentageLetterTransaction != 0)
                            <span class="trend-badge {{ $percentageLetterTransaction > 0 ? 'up' : 'down' }}">
                                @if($percentageLetterTransaction > 0)
                                    <svg viewBox="0 0 12 12"><path d="M2 9l3-3 2 2 3-4"/></svg>
                                @else
                                    <svg viewBox="0 0 12 12"><path d="M2 3l3 3 2-2 3 4"/></svg>
                                @endif
                                {{ abs($percentageLetterTransaction) }}%
                            </span><br>
                        @endif
                        <div class="chart-total">{{ $todayLetterTransaction }}</div>
                        <div class="chart-total-lbl">Total Surat</div>
                    </div>
                </div>
                <div id="today-graphic"></div>
            </div>

        </div>

        {{-- Kolom Kanan — Stat Cards --}}
        <div class="db-col" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">

            {{-- Surat Masuk --}}
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon teal">
                        <svg viewBox="0 0 16 16"><rect x="2" y="3" width="12" height="10" rx="1.5"/><path d="M2 6l6 4 6-4"/></svg>
                    </div>
                    @if($percentageIncomingLetter != 0)
                        <span class="stat-badge {{ $percentageIncomingLetter > 0 ? 'up' : 'down' }}">
                            {{ $percentageIncomingLetter > 0 ? '+' : '' }}{{ $percentageIncomingLetter }}%
                        </span>
                    @else
                        <span class="stat-badge flat">—</span>
                    @endif
                </div>
                <div class="stat-val">{{ $todayIncomingLetter }}</div>
                <div class="stat-lbl">{{ __('dashboard.incoming_letter') }}</div>
                <div class="stat-divider"></div>
                <div class="stat-sub">
                    @if($percentageIncomingLetter > 0) Naik vs kemarin
                    @elseif($percentageIncomingLetter < 0) Turun vs kemarin
                    @else Sama dengan kemarin @endif
                </div>
            </div>

            {{-- Surat Keluar --}}
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon coral">
                        <svg viewBox="0 0 16 16"><rect x="2" y="3" width="12" height="10" rx="1.5"/><path d="M2 6l6 4 6-4"/><path d="M10 9l3-3M10 6h3v3"/></svg>
                    </div>
                    @if($percentageOutgoingLetter != 0)
                        <span class="stat-badge {{ $percentageOutgoingLetter > 0 ? 'up' : 'down' }}">
                            {{ $percentageOutgoingLetter > 0 ? '+' : '' }}{{ $percentageOutgoingLetter }}%
                        </span>
                    @else
                        <span class="stat-badge flat">—</span>
                    @endif
                </div>
                <div class="stat-val">{{ $todayOutgoingLetter }}</div>
                <div class="stat-lbl">{{ __('dashboard.outgoing_letter') }}</div>
                <div class="stat-divider"></div>
                <div class="stat-sub">
                    @if($percentageOutgoingLetter > 0) Naik vs kemarin
                    @elseif($percentageOutgoingLetter < 0) Turun vs kemarin
                    @else Sama dengan kemarin @endif
                </div>
            </div>

            {{-- Disposisi --}}
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon blue">
                        <svg viewBox="0 0 16 16"><path d="M3 4h10M3 8h7M3 12h4"/><path d="M12 10l2 2-2 2"/></svg>
                    </div>
                    @if($percentageDispositionLetter != 0)
                        <span class="stat-badge {{ $percentageDispositionLetter > 0 ? 'up' : 'down' }}">
                            {{ $percentageDispositionLetter > 0 ? '+' : '' }}{{ $percentageDispositionLetter }}%
                        </span>
                    @else
                        <span class="stat-badge flat">—</span>
                    @endif
                </div>
                <div class="stat-val">{{ $todayDispositionLetter }}</div>
                <div class="stat-lbl">{{ __('dashboard.disposition_letter') }}</div>
                <div class="stat-divider"></div>
                <div class="stat-sub">
                    @if($percentageDispositionLetter > 0) Naik vs kemarin
                    @elseif($percentageDispositionLetter < 0) Turun vs kemarin
                    @else Sama dengan kemarin @endif
                </div>
            </div>

            {{-- Pengguna Aktif --}}
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon amber">
                        <svg viewBox="0 0 16 16"><circle cx="8" cy="5.5" r="2.5"/><path d="M3 14c0-2.8 2.2-5 5-5s5 2.2 5 5"/></svg>
                    </div>
                    <span class="stat-badge info">Aktif</span>
                </div>
                <div class="stat-val">{{ $activeUser }}</div>
                <div class="stat-lbl">{{ __('dashboard.active_user') }}</div>
                <div class="stat-divider"></div>
                <div class="stat-sub">Total pengguna terdaftar</div>
            </div>

        </div>
    </div>
</div>{{-- end .desktop-view --}}


{{-- ══════════════════════════════════════
     MOBILE VIEW < 1200px
     Struktur berbeda total dari desktop
══════════════════════════════════════ --}}
<div class="mobile-view">

    {{-- Mini stat strip --}}
    <div class="mob-section">
        <div class="mob-section-title">Hari Ini</div>
        <div class="mob-stats">
            <div class="mob-stat">
                <div class="mob-stat-num">{{ $todayIncomingLetter }}</div>
                <div class="mob-stat-lbl">Masuk</div>
            </div>
            <div class="mob-stat">
                <div class="mob-stat-num">{{ $todayOutgoingLetter }}</div>
                <div class="mob-stat-lbl">Keluar</div>
            </div>
            <div class="mob-stat">
                <div class="mob-stat-num">{{ $todayDispositionLetter }}</div>
                <div class="mob-stat-lbl">Disposisi</div>
            </div>
        </div>
    </div>

    {{-- Quick Action Hub --}}
    <div class="mob-section">
        <div class="mob-section-title">Aksi Cepat</div>
        <div class="quick-actions">
            <a href="{{ route('transaction.incoming.create') }}" class="qa-card incoming">
                <div class="qa-icon">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="15" rx="2"/><path d="M3 9l9 6 9-6"/><path d="M12 15v5M9 17l3 3 3-3"/></svg>
                </div>
                <div>
                    <div class="qa-label">Tambah Surat Masuk</div>
                    <div class="qa-sub">Input · Record</div>
                </div>
            </a>
            <a href="{{ route('transaction.outgoing.create') }}" class="qa-card outgoing">
                <div class="qa-icon">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="15" rx="2"/><path d="M3 9l9 6 9-6"/><path d="M12 10V5M9 8l3-3 3 3"/></svg>
                </div>
                <div>
                    <div class="qa-label">Tambah Surat Keluar</div>
                    <div class="qa-sub">Input · Record</div>
                </div>
            </a>
        </div>
    </div>

    {{-- Navigation Grid 2×2 --}}
    <div class="mob-section">
        <div class="mob-section-title">Menu</div>
        <div class="nav-grid" style="grid-template-columns:repeat(2,1fr);">
            <a href="{{ route('agenda.incoming') }}" class="nav-grid-item">
                <div class="ng-icon teal">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/></svg>
                </div>
                <div class="ng-label">Agenda Surat</div>
            </a>
            <a href="{{ route('transaction.incoming.index') }}" class="nav-grid-item">
                <div class="ng-icon blue">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <div class="ng-label">Transaksi</div>
            </a>

            {{--
                FIX: route('reference.classification.index') — sesuaikan
                dengan hasil: php artisan route:list | grep reference
                Jika route-nya 'reference.index' → ganti baris href di bawah
            --}}
            <a href="{{ route('reference.classification.index') }}" class="nav-grid-item">
                <div class="ng-icon coral">
                    <svg viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h10M4 18h7"/><rect x="14" y="13" width="7" height="7" rx="1"/></svg>
                </div>
                <div class="ng-label">Klasifikasi</div>
            </a>

            @if(auth()->user()->role == 'admin')
                <a href="{{ route('user.index') }}" class="nav-grid-item">
                    <div class="ng-icon amber">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="ng-label">Manajemen User</div>
                </a>
            @else
                <a href="{{ route('agenda.outgoing') }}" class="nav-grid-item">
                    <div class="ng-icon amber">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18M8 14h8M8 18h5"/></svg>
                    </div>
                    <div class="ng-label">Agenda Keluar</div>
                </a>
            @endif
        </div>
    </div>

    {{-- Recent Activity Log --}}
    <div class="mob-section">
        <div class="mob-section-title">Log Surat Terbaru</div>
        <div class="activity-list">

            @forelse($recentLetters as $letter)
                @php
                    // AUTO-DETECT nomor surat.
                    //     Coba semua kemungkinan nama kolom yang umum dipakai
                    //     di project e-surat Laravel. Sesuaikan urutan prioritas
                    //     kalau kolom di tabel kamu berbeda.
                    $nomorSurat = $letter->letter_number
                        ?? $letter->number
                        ?? $letter->nomor_surat
                        ?? $letter->no_surat
                        ?? $letter->nomor
                        ?? $letter->perihal
                        ?? $letter->subject
                        ?? '—';

                    // {{--
                    //     AUTO-DETECT tipe surat.
                    //     Nilai yang diterima: 'incoming'/'masuk'/'in'
                    //     atau 'outgoing'/'keluar'/'out'.
                    // --}}
                    $rawTipe    = strtolower(
                        $letter->letter_type
                        ?? $letter->type
                        ?? $letter->jenis
                        ?? $letter->jenis_surat
                        ?? ''
                    );
                    $isIncoming = in_array($rawTipe, ['incoming', 'masuk', 'in']);

                    // {{--
                    //     AUTO-DETECT pengirim (surat masuk) / penerima (surat keluar).
                    //     Coba kolom langsung dulu, lalu coba relasi model jika ada.
                    // --}}
                    if ($isIncoming) {
                        $pihak = $letter->from
                            ?? $letter->sender
                            ?? $letter->pengirim
                            ?? $letter->asal
                            ?? $letter->instansi_pengirim
                            ?? ($letter->senderRelation->name ?? null)
                            ?? ($letter->from_name ?? null)
                            ?? '-';
                    } else {
                        $pihak = $letter->to
                            ?? $letter->recipient
                            ?? $letter->penerima
                            ?? $letter->tujuan
                            ?? $letter->instansi_tujuan
                            ?? ($letter->recipientRelation->name ?? null)
                            ?? ($letter->to_name ?? null)
                            ?? '-';
                    }

                    // {{--
                    //     AUTO-DETECT tanggal surat.
                    //     Prioritaskan tanggal surat itu sendiri,
                    //     baru fallback ke created_at.
                    // --}}
                    $rawTanggal = $letter->letter_date
                        ?? $letter->tanggal_surat
                        ?? $letter->tanggal
                        ?? $letter->date
                        ?? $letter->created_at
                        ?? null;
                    $tanggalFmt = $rawTanggal
                        ? \Carbon\Carbon::parse($rawTanggal)->format('d/m')
                        : '—';

                    $badgeClass = $isIncoming ? 'in'    : 'out';
                    $badgeLabel = $isIncoming ? 'Masuk' : 'Keluar';
                @endphp

                <div class="act-item">
                    <div class="act-dot {{ $badgeClass }}"></div>
                    <div class="act-body">
                        <div class="act-number">{{ $nomorSurat }}</div>
                        <div class="act-sender">{{ $pihak }}</div>
                    </div>
                    <span class="act-type {{ $badgeClass }}">{{ $badgeLabel }}</span>
                    <div class="act-meta">{{ $tanggalFmt }}</div>
                </div>

            @empty
                <div style="padding:20px 14px; text-align:center; font-family:'DM Mono',monospace; font-size:11px; color:var(--text-hint);">
                    Belum ada aktivitas surat
                </div>
            @endforelse

        </div>
    </div>

    <div class="mob-bottom-spacer"></div>

</div>{{-- end .mobile-view --}}


{{-- ══════════════════════════════════════
     BOTTOM TAB BAR — mobile only
     Hidden di ≥ 1200px via CSS
══════════════════════════════════════ --}}
<nav class="bottom-tab">
    <a href="{{ route('home') }}"
       class="tab-item {{ Route::is('home') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span class="tab-label">Home</span>
    </a>
    <a href="{{ route('transaction.incoming.index') }}"
       class="tab-item {{ Route::is('transaction.incoming.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="15" rx="2"/><path d="M3 9l9 6 9-6"/></svg>
        <span class="tab-label">Masuk</span>
    </a>
    <a href="{{ route('agenda.incoming') }}"
       class="tab-item {{ Route::is('agenda.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        <span class="tab-label">Agenda</span>
    </a>
    <a href="{{ route('transaction.outgoing.index') }}"
       class="tab-item {{ Route::is('transaction.outgoing.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="15" rx="2"/><path d="M3 9l9 6 9-6"/><path d="M12 10V5M9 8l3-3 3 3"/></svg>
        <span class="tab-label">Keluar</span>
    </a>
</nav>

@endsection
{{-- ↑ WAJIB ADA — jangan hapus --}}