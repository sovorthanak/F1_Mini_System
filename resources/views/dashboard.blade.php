<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Leaflet (Map) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


    <style>
        /* Dashboard wrapper */
        .main-container{
            width: 100%;
            max-width: 1700px;
            margin: 0 auto;
            padding: 10px 10px 30px;
        }

        /* Rows */
        .row-layout{
            width: 100%;
            display:flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Chart container */
        .chart-container{
            border-radius: 10px;
            transition: transform .2s ease, box-shadow .2s ease;
            position: relative;
        }
        .chart-container:hover{
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,.12);
        }

        /* Ensure link overlay works ONLY when you want it */
        .chart-link{
            position:absolute;
            inset:0;
            z-index: 2;
            border-radius: 10px;
            display:block;
        }

        /* Content above the link overlay (so canvas can still be clickable when needed) */
        .chart-content{
            position: relative;
            z-index: 3;
            width: 100%;
        }

        /* Titles */
        .chart-title{
            width: 100%;
            display:flex;
            justify-content: space-between;
            align-items:center;
            font-size: 18px;
            font-weight: 500;
            color:#043066;
            margin-bottom: 10px;
        }
        .chart-subtitle{
            font-size: 12px;
            color:#6c757d;
        }

        /* Default chart size */
        .chart-area{
            width: 100%;
        }
        .chart-area-sm{
            width: 100%;
        }

        /* ✅ Make ONLY charts that use JS onClick clickable */
        #customersByLocationChart,
        #customerChart,
        #tariffChart,
        #statusChart{
            pointer-events: auto !important;
        }

        /* ✅ Default: canvases can receive clicks (do NOT disable globally) */
        .chart-area canvas,
        .chart-area-sm canvas{
            pointer-events: auto;
        }

        /* ✅ If a container uses <a class="chart-link"> overlay,
        then disable canvas clicks for that container ONLY */
        .chart-container.has-link .chart-area canvas,
        .chart-container.has-link .chart-area-sm canvas{
            pointer-events: none;
        }

        /* ✅ BIGGER Tariff Chart (more height for many items) */
        .chart-area-tariff{
            width: 100%;
        }

        /* ===============================
        UNIVERSAL CHART CARD LAYOUT
        ================================= */
        .chart-container{
            background: #fff;
            border-radius: 10px;
            padding: 14px 25px 12px;
            box-sizing: border-box;

            display: flex;
            flex-direction: column;
        }

        /* Title always takes natural height */
        .chart-title{
            flex: 0 0 auto;
            margin-bottom: 10px;
        }

        /* Chart content fills remaining card height */
        .chart-content{
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            min-height: 0; /* IMPORTANT */
        }

        /* Make every chart area fill remaining space */
        .chart-area,
        .chart-area-sm,
        .chart-area-tariff{
            flex: 1 1 auto;
            min-height: 0;  /* IMPORTANT */
            position: relative;
            width: 100%;
            height: auto !important; /* override fixed 320/280/520 */
        }

        /* Canvas must always stretch */
        .chart-area canvas,
        .chart-area-sm canvas,
        .chart-area-tariff canvas{
            width: 100% !important;
            height: 100% !important;
            display: block;
        }


        /* Responsive */
        @media(max-width: 900px){
            .chart-container{
                width: 100% !important;
                max-width: 900px;
            }
            .chart-area-tariff{
                height: 520px;
            }
        }
    </style>

    <div class="main-container">

        <!-- KPI CARDS (keep your existing CSS targets) -->
        <div class="row-layout">
            <div class="data-card text-white">
                <h5 class="card-heading">Customers <i class="fas fa-users me-2"></i></h5>
                <p class="metric-value">{{ $totalCustomers }}</p>
            </div>

            <div class="data-card text-white">
                <h5 class="card-heading">Revenue <i class="fas fa-dollar-sign me-2"></i></h5>
                <p class="metric-value">$ {{ number_format($totalRevenue, 2) }}</p>
            </div>

            <div class="data-card text-white">
                <h5 class="card-heading">Invoices <i class="fas fa-file-invoice me-2"></i></h5>
                <p class="metric-value">{{ $totalInvoices }}</p>
            </div>

            <div class="data-card text-white">
                <h5 class="card-heading">Unpaid Invoices <i class="fas fa-file-invoice-dollar me-2"></i></h5>
                <p class="metric-value">{{ $unpaidInvoices }}</p>
            </div>

            <div class="data-card text-white">
                <h5 class="card-heading">Unpaid Amount <i class="fas fa-wallet me-2"></i></h5>
                <p class="metric-value">$ {{ number_format($totalUnpaidAmount, 2) }}</p>
            </div>
        </div>

        <!-- ROW 1 -->
        <div class="row-layout">
            <div class="chart-container" style="width:700px;">
                <a class="chart-link" href="/customers" aria-label="New Customers"></a>
                <div class="chart-content">
                    <div class="chart-title">
                        <span>New Customers (Last 30 Days)</span>
                        <span class="chart-subtitle">Click to view</span>
                    </div>
                    <div class="chart-area">
                        <canvas id="customerChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="chart-container" style="width:400px;">
                <div class="chart-content">
                    <div class="chart-title">
                        <span>Customer Status Distribution</span>
                        <span class="chart-subtitle">Click to view</span>
                    </div>
                    <div class="chart-area-sm">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="chart-container" style="width:400px;">
                <a class="chart-link" href="/request-change" aria-label="Request Change Distribution" style="z-index: 10; heigh:100%"></a>
                <div class="chart-content">
                    <div class="chart-title">
                        <span>Request Change Distribution</span>
                        <span class="chart-subtitle">Click to view</span>
                    </div>
                    <div class="chart-area-sm">
                        <canvas id="requestChangeDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-layout">
            <div class="chart-container" style="width:500px; height:600px;">
                <div class="chart-content">
                    <div class="chart-title">
                    <span>Tariff Distribution</span>
                        <span class="chart-subtitle">Click to view</span>
                    </div>
                    <div class="chart-area-tariff">
                        <canvas id="tariffChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="chart-container" style="width:800px;">
                <a class="chart-link" href="/dashboard/updating" aria-label="Monthly Revenue"></a>
                <div class="chart-content">
                    <div class="chart-title">
                        <span>Monthly Revenue</span>
                        <span class="chart-subtitle">Click to view</span>
                    </div>
                    <div class="chart-area">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- <div class="chart-container" style="width:800px;">
                <h2 class="chart-title">Customer Map (Cambodia)</h2>
                <div class="chart-container" id="customerMap" style="width: 100%; height: 100%; border-radius: 10px;"></div>
            </div> --}}
        </div>

        <!-- ROW 2 -->
        <div class="row-layout">
            <div class="chart-container" style="width:650px;">
                <div class="chart-content">
                    <div class="chart-title">
                        <span>Customer Count by Location</span>
                        <span class="chart-subtitle">Click to view</span>
                    </div>
                    <div class="chart-area">
                        <canvas id="customersByLocationChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="chart-container" style="width:650px;">
                <a class="chart-link" href="/request-change" aria-label="Request Change" style="z-index: 10; heigh:100%"></a>
                <div class="chart-content">
                    <div class="chart-title">
                        <span>Request Change (Last 30 Days)</span>
                        <span class="chart-subtitle">Click to view</span>
                    </div>
                    <div class="chart-area">
                        <canvas id="requestChangeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW 3 (3 charts like your existing row-layout nth-child(4)) -->
        <div class="row-layout">


        </div>

    </div>

    <script>
        // Shared defaults (keeps charts consistent)
        Chart.defaults.font.family = 'system-ui, -apple-system, Segoe UI, Roboto, Arial';
        Chart.defaults.plugins.legend.labels.boxWidth = 12;

        // Monthly Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: @json(array_column($revenueData, 'month')),
                datasets: [{
                    label: 'Monthly Paid Revenue ($)',
                    data: @json(array_column($revenueData, 'revenue')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Revenue ($)' } },
                    x: { title: { display: true, text: 'Month' } }
                }
            }
        });

        // New Customers Chart - CLICKABLE
        const customerCanvas = document.getElementById('customerChart');
        const customerCtx = customerCanvas.getContext('2d');

        const newCustomersChart = new Chart(customerCtx, {
            type: 'line',
            data: {
                labels: @json(array_keys($newCustomers)),   // YYYY-MM-DD
                datasets: [{
                label: 'New Registers',
                data: @json(array_values($newCustomers)),
                fill: true,
                tension: 0.35,
                pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                x: { title: { display: true, text: 'Creation Date' } },
                y: { beginAtZero: true, title: { display: true, text: 'Number of Customers' } }
                },

                // ✅ CLICK → PASS ONE DATE → SET BOTH min & max
                onClick: function (evt) {
                const points = newCustomersChart.getElementsAtEventForMode(
                    evt,
                    'nearest',
                    { intersect: true },
                    true
                );

                if (!points.length) return;

                const index = points[0].index;
                const selectedDate = newCustomersChart.data.labels[index]; // YYYY-MM-DD

                const url = new URL('/customers', window.location.origin);
                url.searchParams.set('min_date', selectedDate);
                url.searchParams.set('max_date', selectedDate);

                window.location.href = url.toString();
                }
            }
            });

        // Pointer cursor
        customerCanvas.addEventListener('mousemove', (e) => {
            const points = newCustomersChart.getElementsAtEventForMode(
                e, 'nearest', { intersect: true }, true
            );
            customerCanvas.style.cursor = points.length ? 'pointer' : 'default';
        });

        // Change Requests Chart
        const requestChangeCtx = document.getElementById('requestChangeChart').getContext('2d');
        new Chart(requestChangeCtx, {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: @json($requestChangeDatasets)
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { title: { display: true, text: 'Request Date' } },
                    y: { beginAtZero: true, title: { display: true, text: 'Number of Change Requests' } }
                }
            }
        });

        // Request Change Distribution (Pie)
        const requestChangeDistributionCtx = document.getElementById('requestChangeDistributionChart').getContext('2d');
        new Chart(requestChangeDistributionCtx, {
            type: 'pie',
            data: {
                labels: @json(array_keys($requestTypeTotals)),
                datasets: [{
                    label: 'Request Change Distribution',
                    data: @json(array_values($requestTypeTotals))
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Customer Status Distribution (Doughnut) - CLICKABLE
        const statusCanvas = document.getElementById('statusChart');
        const statusCtx = statusCanvas.getContext('2d');

        const statusLabels = @json(array_keys($statusDistribution));
        const statusValues = @json(array_values($statusDistribution));

        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                // ✅ CLICK → go to /customers?status=...
                onClick: function (evt) {
                    const points = statusChart.getElementsAtEventForMode(
                        evt, 'nearest', { intersect: true }, true
                    );
                    if (!points.length) return;

                    const index = points[0].index;
                    const statusLabel = statusChart.data.labels[index];

                    const url = new URL('/customers', window.location.origin);
                    url.searchParams.set('status', statusLabel);
                    window.location.href = url.toString();
                }
            }
        });

        // Pointer cursor
        statusCanvas.addEventListener('mousemove', (e) => {
            const points = statusChart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true);
            statusCanvas.style.cursor = points.length ? 'pointer' : 'default';
        });


        // Tariff Distribution (Horizontal Bar) - CLICKABLE
        const tariffCanvas = document.getElementById('tariffChart');
        const tariffCtx = tariffCanvas.getContext('2d');

        const tariffLabels = @json(array_keys($tariffCounts));
        const tariffValues = @json(array_values($tariffCounts));

        const tariffChart = new Chart(tariffCtx, {
            type: 'bar',
            data: {
                labels: tariffLabels,
                datasets: [{
                    label: 'Customers by Tariff',
                    data: tariffValues,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y', // ✅ horizontal bar
                scales: {
                    x: { beginAtZero: true, title: { display: true, text: 'Customers' } },
                    y: {
                        ticks: {
                            // ✅ keep labels readable if long
                            callback: function(value) {
                                const label = this.getLabelForValue(value);
                                return label.length > 22 ? label.slice(0, 22) + '…' : label;
                            }
                        }
                    }
                },
                plugins: { legend: { display: false } },

                // ✅ CLICK → go to /customers?tariff=...
                onClick: function (evt) {
                    const points = tariffChart.getElementsAtEventForMode(
                        evt, 'nearest', { intersect: true }, true
                    );
                    if (!points.length) return;

                    const index = points[0].index;
                    const tariffLabel = tariffChart.data.labels[index];

                    const url = new URL('/customers', window.location.origin);
                    url.searchParams.set('tariff', tariffLabel);   // ✅ you must support this param in customers page
                    window.location.href = url.toString();
                }
            }
        });

        // Pointer cursor
        tariffCanvas.addEventListener('mousemove', (e) => {
            const points = tariffChart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true);
            tariffCanvas.style.cursor = points.length ? 'pointer' : 'default';
        });


        // Customers by Location (Bar) - CLICKABLE (ONLY ONCE)
        const customersByLocationCtx = document.getElementById('customersByLocationChart').getContext('2d');

        const customersByLocationChart = new Chart(customersByLocationCtx, {
            type: 'bar',
            data: {
                labels: @json(array_keys($customersByLocation)),
                datasets: [{
                label: 'Customers by Location',
                data: @json(array_values($customersByLocation)),
                borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Number of Customers' } },
                x: { title: { display: true, text: 'Location' } }
                },
                plugins: { legend: { display: false } },

                onClick: function (evt) {
                const points = customersByLocationChart.getElementsAtEventForMode(
                    evt, 'nearest', { intersect: true }, true
                );
                if (!points.length) return;

                const index = points[0].index;
                const locationLabel = customersByLocationChart.data.labels[index];

                const url = new URL('/customers', window.location.origin);
                url.searchParams.set('location', locationLabel);
                window.location.href = url.toString();
                }
            }
        });

        // pointer cursor on hover
        const locCanvas = document.getElementById('customersByLocationChart');
            locCanvas.addEventListener('mousemove', (e) => {
            const points = customersByLocationChart.getElementsAtEventForMode(
                e, 'nearest', { intersect: true }, true
            );
            locCanvas.style.cursor = points.length ? 'pointer' : 'default';
        });

        // -----------------------------------------
        // 1) DATA FROM BACKEND
        // -----------------------------------------
        // In controller, build $customerPoints (example below)
        // Then pass it here:
        const customerPoints = @json($customerPoints ?? []);

        // -----------------------------------------
        // 2) LEAFLET MAP INIT (Cambodia Center)
        // -----------------------------------------
        const map = L.map('customerMap').setView([12.5657, 104.9910], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Keep bounds to auto-fit markers
            const bounds = L.latLngBounds();

            // Add markers
            customerPoints.forEach(p => {
                if (!p.lat || !p.lng) return;

                const marker = L.marker([p.lat, p.lng]).addTo(map);
                marker.bindPopup(`
                    <b>${p.customer_name ?? 'Customer'}</b><br>
                    ${p.province ?? ''}<br>
                    Status: ${p.status ?? ''}<br>
                    Tariff: ${p.tariff_name ?? ''}<br>
                    Bandwidth: ${p.bandwidth ?? ''}
                `);

                bounds.extend([p.lat, p.lng]);
            });

            // Fit map to markers if we have any
            if (customerPoints.length > 0 && bounds.isValid()) {
                map.fitBounds(bounds.pad(0.15));
        }

    </script>

    <!-- YOUR ORIGINAL CHART.JS SCRIPT CAN STAY THE SAME -->
</x-app-layout>
