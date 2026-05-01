@extends('layout.main')

@push('style')
    <link rel="stylesheet" href="{{asset('sneat/vendor/libs/apex-charts/apex-charts.css')}}" />
    <style>
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-card: #ffffff;
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --border-color: #e2e8f0;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        [data-theme="dark"] {
            --bg-primary: #1a202c;
            --bg-secondary: #2d3748;
            --bg-card: #2d3748;
            --text-primary: #f7fafc;
            --text-secondary: #cbd5e0;
            --border-color: #4a5568;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            --shadow-hover: 0 4px 16px rgba(0, 0, 0, 0.4);
        }

        body {
            background-color: var(--bg-secondary);
            transition: background-color 0.3s ease;
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: var(--bg-card);
            border: 2px solid var(--border-color);
            border-radius: 50px;
            padding: 8px 16px;
            cursor: pointer;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .theme-toggle:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        .theme-toggle i {
            font-size: 20px;
            color: var(--text-primary);
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-hover);
        }

        .welcome-section {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 12px;
            padding: 32px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .welcome-section h4 {
            font-weight: 600;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .welcome-section p {
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
            margin-bottom: 16px;
        }

        .stat-icon.success { background: #10b981; }
        .stat-icon.danger { background: #ef4444; }
        .stat-icon.primary { background: #3b82f6; }
        .stat-icon.info { background: #06b6d4; }

        .stat-label {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 8px;
            font-weight: 500;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .stat-change {
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .stat-change.positive {
            color: #10b981;
            background: rgba(16, 185, 129, 0.1);
        }

        .stat-change.negative {
            color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
        }

        .chart-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .chart-badge {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .total-metric {
            text-align: right;
        }

        .total-metric .value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .total-metric .label {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .illustration-wrapper {
            position: relative;
            z-index: 1;
        }

        .illustration-wrapper img {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
        }

        [data-theme="dark"] .illustration-wrapper img {
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.5)) brightness(0.9);
        }

        @media (max-width: 768px) {
            .theme-toggle {
                top: 10px;
                right: 10px;
                padding: 6px 12px;
            }
        }
    </style>
@endpush

@push('script')
    <script src="{{asset('sneat/vendor/libs/apex-charts/apexcharts.js')}}"></script>
    <script>
        // Dark Mode Toggle
        const themeToggle = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;
        const sunIcon = document.getElementById('sunIcon');
        const moonIcon = document.getElementById('moonIcon');

        // Check saved theme
        const currentTheme = localStorage.getItem('theme') || 'light';
        htmlElement.setAttribute('data-theme', currentTheme);
        updateIcons(currentTheme);

        themeToggle.addEventListener('click', () => {
            const theme = htmlElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            htmlElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            updateIcons(theme);
            
            // Redraw chart with new theme
            chart.destroy();
            initChart();
        });

        function updateIcons(theme) {
            if (theme === 'dark') {
                sunIcon.style.display = 'block';
                moonIcon.style.display = 'none';
            } else {
                sunIcon.style.display = 'none';
                moonIcon.style.display = 'block';
            }
        }

        // Chart Configuration
        let chart;

        function getChartColors() {
            const isDark = htmlElement.getAttribute('data-theme') === 'dark';
            return {
                text: isDark ? '#cbd5e0' : '#718096',
                grid: isDark ? '#4a5568' : '#e2e8f0',
                tooltip: isDark ? '#2d3748' : '#ffffff'
            };
        }

        function initChart() {
            const colors = getChartColors();
            
            const options = {
                chart: {
                    type: 'bar',
                    height: 280,
                    toolbar: {
                        show: false
                    },
                    background: 'transparent'
                },
                series: [{
                    name: '{{ __('dashboard.letter_transaction') }}',
                    data: [{{ $todayIncomingLetter }}, {{ $todayOutgoingLetter }}, {{ $todayDispositionLetter }}]
                }],
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '45%',
                        distributed: true,
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                colors: ['#10b981', '#ef4444', '#3b82f6'],
                dataLabels: {
                    enabled: true,
                    offsetY: -20,
                    style: {
                        fontSize: '13px',
                        fontWeight: 600,
                        colors: [colors.text]
                    }
                },
                xaxis: {
                    categories: [
                        '{{ __('dashboard.incoming_letter') }}',
                        '{{ __('dashboard.outgoing_letter') }}',
                        '{{ __('dashboard.disposition_letter') }}',
                    ],
                    labels: {
                        style: {
                            colors: colors.text,
                            fontSize: '12px'
                        }
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: colors.text,
                            fontSize: '12px'
                        }
                    }
                },
                grid: {
                    borderColor: colors.grid,
                    strokeDashArray: 4,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    }
                },
                legend: {
                    show: false
                },
                tooltip: {
                    theme: htmlElement.getAttribute('data-theme'),
                    y: {
                        formatter: function(val) {
                            return val + " letters"
                        }
                    }
                }
            };

            chart = new ApexCharts(document.querySelector("#today-graphic"), options);
            chart.render();
        }

        // Initialize chart
        initChart();
    </script>
@endpush

@section('content')
    <!-- Theme Toggle Button -->
    <div class="theme-toggle" id="themeToggle">
        <i class='bx bx-sun' id="sunIcon" style="display: none;"></i>
        <i class='bx bx-moon' id="moonIcon"></i>
    </div>

    <div class="row">
        <!-- Welcome Section -->
        <div class="col-lg-8 mb-4">
            <div class="welcome-section">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h4>{{ $greeting }}</h4>
                        <p class="mb-3">{{ $currentDate }}</p>
                        <small style="opacity: 0.9;">{{ __('dashboard.today_report') }}</small>
                    </div>
                    <div class="col-md-5 text-center">
                        <div class="illustration-wrapper">
                            <svg width="140" height="140" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Background circle -->
                                <circle cx="100" cy="100" r="90" fill="rgba(255,255,255,0.1)"/>
                                
                                <!-- Blackboard -->
                                <rect x="50" y="40" width="100" height="70" rx="4" fill="rgba(255,255,255,0.2)"/>
                                <rect x="55" y="45" width="90" height="60" fill="rgba(255,255,255,0.15)"/>
                                
                                <!-- Chart on blackboard -->
                                <polyline points="70,85 80,75 90,80 100,65 110,70 120,60" stroke="rgba(255,255,255,0.4)" stroke-width="2" fill="none"/>
                                <line x1="65" y1="90" x2="135" y2="90" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                                <line x1="65" y1="90" x2="65" y2="50" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
                                
                                <!-- Teacher head -->
                                <circle cx="100" cy="130" r="18" fill="rgba(255,255,255,0.9)"/>
                                
                                <!-- Teacher body -->
                                <rect x="88" y="145" width="24" height="35" rx="12" fill="rgba(255,255,255,0.8)"/>
                                
                                <!-- Arms -->
                                <ellipse cx="80" cy="155" rx="8" ry="15" fill="rgba(255,255,255,0.8)" transform="rotate(-20 80 155)"/>
                                <ellipse cx="120" cy="155" rx="8" ry="15" fill="rgba(255,255,255,0.8)" transform="rotate(20 120 155)"/>
                                
                                <!-- Pointing hand -->
                                <circle cx="130" cy="75" r="5" fill="rgba(255,255,255,0.9)"/>
                                <line x1="120" y1="150" x2="130" y2="75" stroke="rgba(255,255,255,0.8)" stroke-width="3" stroke-linecap="round"/>
                                
                                <!-- Book -->
                                <rect x="70" y="160" width="15" height="12" rx="1" fill="rgba(255,255,255,0.6)"/>
                                <line x1="77.5" y1="160" x2="77.5" y2="172" stroke="rgba(255,255,255,0.9)" stroke-width="1"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="mt-4">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <div class="chart-title">{{ __('dashboard.today_graphic') }}</div>
                            <span class="chart-badge mt-2">{{ __('dashboard.today') }}</span>
                        </div>
                        <div class="total-metric">
                            @if($percentageLetterTransaction != 0)
                                <span class="stat-change {{ $percentageLetterTransaction > 0 ? 'positive' : 'negative' }}">
                                    <i class='bx bx-{{ $percentageLetterTransaction > 0 ? 'trending-up' : 'trending-down' }}'></i>
                                    {{ abs($percentageLetterTransaction) }}%
                                </span>
                            @endif
                            <div class="value">{{ $todayLetterTransaction }}</div>
                            <div class="label">Total Transactions</div>
                        </div>
                    </div>
                    <div id="today-graphic"></div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="col-lg-4">
            <div class="row">
                <!-- Incoming Letter -->
                <div class="col-lg-12 col-md-6 col-sm-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon success">
                            <i class='bx bx-envelope'></i>
                        </div>
                        <div class="stat-label">{{ __('dashboard.incoming_letter') }}</div>
                        <div class="stat-value">{{ $todayIncomingLetter }}</div>
                        @if($percentageIncomingLetter != 0)
                            <span class="stat-change {{ $percentageIncomingLetter > 0 ? 'positive' : 'negative' }}">
                                <i class='bx bx-{{ $percentageIncomingLetter > 0 ? 'up-arrow-alt' : 'down-arrow-alt' }}'></i>
                                {{ abs($percentageIncomingLetter) }}% today
                            </span>
                        @else
                            <span class="stat-change" style="color: var(--text-secondary); background: transparent;">
                                No change
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Outgoing Letter -->
                <div class="col-lg-12 col-md-6 col-sm-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon danger">
                            <i class='bx bx-envelope'></i>
                        </div>
                        <div class="stat-label">{{ __('dashboard.outgoing_letter') }}</div>
                        <div class="stat-value">{{ $todayOutgoingLetter }}</div>
                        @if($percentageOutgoingLetter != 0)
                            <span class="stat-change {{ $percentageOutgoingLetter > 0 ? 'positive' : 'negative' }}">
                                <i class='bx bx-{{ $percentageOutgoingLetter > 0 ? 'up-arrow-alt' : 'down-arrow-alt' }}'></i>
                                {{ abs($percentageOutgoingLetter) }}% today
                            </span>
                        @else
                            <span class="stat-change" style="color: var(--text-secondary); background: transparent;">
                                No change
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Disposition Letter -->
                <div class="col-lg-12 col-md-6 col-sm-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon primary">
                            <i class='bx bx-envelope'></i>
                        </div>
                        <div class="stat-label">{{ __('dashboard.disposition_letter') }}</div>
                        <div class="stat-value">{{ $todayDispositionLetter }}</div>
                        @if($percentageDispositionLetter != 0)
                            <span class="stat-change {{ $percentageDispositionLetter > 0 ? 'positive' : 'negative' }}">
                                <i class='bx bx-{{ $percentageDispositionLetter > 0 ? 'up-arrow-alt' : 'down-arrow-alt' }}'></i>
                                {{ abs($percentageDispositionLetter) }}% today
                            </span>
                        @else
                            <span class="stat-change" style="color: var(--text-secondary); background: transparent;">
                                No change
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Active Users -->
                <div class="col-lg-12 col-md-6 col-sm-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon info">
                            <i class='bx bx-user-check'></i>
                        </div>
                        <div class="stat-label">{{ __('dashboard.active_user') }}</div>
                        <div class="stat-value">{{ $activeUser }}</div>
                        <span class="stat-change" style="color: var(--text-secondary); background: transparent;">
                            Total active users
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection