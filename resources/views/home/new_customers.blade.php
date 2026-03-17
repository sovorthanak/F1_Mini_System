<x-app-layout>
    <style>
        :root{
            --bg: #f6f7fb;
            --card: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --primary: #6366f1;
            --shadow: 0 8px 24px rgba(17,24,39,.08);
            --radius: 14px;

            --green: #22c55e;
            --amber: #f59e0b;
            --gray: #d1d5db;
        }

        /* Layout */
        .page-wrap{
            padding: 18px;
            display: flex;
            justify-content: center;
            min-height: calc(100vh - 20px);
        }
        .container{
            width: 1100px;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Header */
        .header{
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding: 18px;
            border: 1px solid var(--border);
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }
        .header h1{
            margin: 0;
            font-size: 18px;
            color: var(--text);
            font-weight: 900;
            letter-spacing: .2px;
        }
        .header p{
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 12px;
        }
        .pill{
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 999px;
            border: 1px solid var(--border);
            color: var(--muted);
            font-size: 12px;
            background: #fff;
            white-space: nowrap;
        }
        .pill i{ color: var(--primary); }

        /* KPI grid */
        .kpi-grid{
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }
        @media (max-width: 980px){
            .kpi-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 520px){
            .kpi-grid{ grid-template-columns: 1fr; }
        }
        .kpi{
            border: 1px solid var(--border);
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }
        .kpi .label{
            font-size: 12px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 800;
        }
        .kpi .label i{ color: var(--primary); }
        .kpi .value{
            font-size: 26px;
            font-weight: 950;
            color: var(--text);
            line-height: 1;
        }
        .kpi .sub{
            margin-top: 6px;
            font-size: 11px;
            color: var(--muted);
        }
        .kpi .right{ text-align: right; }

        /* Section card */
        .section{
            border: 1px solid var(--border);
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 16px;
        }
        .section-title{
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
        }
        .section-title h2{
            margin: 0;
            font-size: 14px;
            color: var(--text);
            font-weight: 950;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Controls */
        .controls{
            display: grid;
            grid-template-columns: 1fr 190px;
            gap: 10px;
            margin-top: 10px;
        }
        @media (max-width: 720px){
            .controls{ grid-template-columns: 1fr; }
        }
        .input, .select{
            width: 100%;
            padding: 11px 12px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: #fff;
            font-size: 12px;
            color: var(--text);
            outline: none;
        }
        .input:focus, .select:focus{
            border-color: rgba(99,102,241,.55);
            box-shadow: 0 0 0 4px rgba(99,102,241,.12);
        }

        /* Daily list */
        .daily-wrap{
            margin-top: 12px;
            max-height: 520px;
            overflow: auto;
            padding-right: 6px;
        }
        .daily-wrap::-webkit-scrollbar{ width: 8px; }
        .daily-wrap::-webkit-scrollbar-track{ background: #f1f1f1; border-radius: 10px; }
        .daily-wrap::-webkit-scrollbar-thumb{ background: rgba(99,102,241,.75); border-radius: 10px; }

        .row{
            display: grid;
            grid-template-columns: 1fr 110px 160px;
            align-items: center;
            gap: 10px;
            padding: 12px;
            border: 1px solid var(--border);
            background: #fff;
            border-radius: 12px;
            margin-bottom: 10px;
            transition: transform .12s ease, box-shadow .12s ease, border-color .12s ease;
            cursor: pointer;
            user-select: none;
        }
        .row:hover{
            transform: translateY(-1px);
            box-shadow: 0 10px 26px rgba(17,24,39,.08);
            border-color: rgba(99,102,241,.35);
        }
        .row:active{ transform: translateY(0); }

        @media (max-width: 560px){
            .row{
                grid-template-columns: 1fr 92px;
                grid-template-areas:
                    "date badge"
                    "meta meta";
            }
            .meta{ grid-area: meta; justify-self: start; text-align: left; }
        }

        .date{
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        .date .d{
            font-weight: 950;
            color: var(--text);
            font-size: 13px;
        }
        .date .w{
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .45px;
        }

        .badge{
            justify-self: end;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 999px;
            border: 1px solid var(--border);
            font-weight: 950;
            font-size: 12px;
            color: var(--text);
            background: #fff;
        }
        .badge .dot{ width: 10px; height: 10px; border-radius: 50%; }

        .meta{
            justify-self: end;
            text-align: right;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.3;
        }
        .hint{
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary);
            font-weight: 900;
            margin-top: 4px;
        }

        /* Category colors */
        .high .badge .dot{ background: var(--green); }
        .medium .badge .dot{ background: var(--amber); }
        .low .badge .dot{ background: var(--gray); }

        .no-data{
            padding: 34px;
            text-align: center;
            color: var(--muted);
            border: 1px dashed var(--border);
            border-radius: var(--radius);
            background: #fff;
        }

        /* === Drawer (Customer List) === */
        .drawer-backdrop{
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.35);
            z-index: 9999;
            display: none;
        }
        .drawer{
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            width: 440px;
            max-width: 92vw;
            background: #fff;
            border-left: 1px solid var(--border);
            box-shadow: -12px 0 30px rgba(17,24,39,.12);
            transform: translateX(110%);
            transition: transform .18s ease;
            z-index: 10000;
            display: flex;
            flex-direction: column;
        }
        .drawer.open{ transform: translateX(0); }

        .drawer-header{
            padding: 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: #fff;
        }
        .drawer-top{
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        .drawer-title{
            margin: 0;
            font-size: 14px;
            font-weight: 950;
            color: var(--text);
        }
        .drawer-close{
            border: 1px solid var(--border);
            background: #fff;
            border-radius: 10px;
            padding: 8px 10px;
            cursor: pointer;
            font-weight: 900;
            color: var(--text);
        }
        .drawer-close:hover{ box-shadow: 0 8px 18px rgba(17,24,39,.08); }

        .drawer-sub{
            font-size: 12px;
            color: var(--muted);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }
        .count-pill{
            border: 1px solid var(--border);
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 900;
            color: var(--text);
            background: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .count-pill i{ color: var(--primary); }

        .drawer-search{
            width: 100%;
            padding: 11px 12px;
            border-radius: 12px;
            border: 1px solid var(--border);
            outline: none;
            font-size: 12px;
        }
        .drawer-search:focus{
            border-color: rgba(99,102,241,.55);
            box-shadow: 0 0 0 4px rgba(99,102,241,.12);
        }

        .drawer-body{
            padding: 14px 16px;
            overflow: auto;
            flex: 1;
            background: #fff;
        }
        .drawer-body::-webkit-scrollbar{ width: 8px; }
        .drawer-body::-webkit-scrollbar-track{ background: #f1f1f1; border-radius: 10px; }
        .drawer-body::-webkit-scrollbar-thumb{ background: rgba(99,102,241,.75); border-radius: 10px; }

        .name-grid{
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .name-item{
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            background: #fff;
        }
        .name-left{
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }
        .avatar{
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: rgba(99,102,241,.12);
            display: grid;
            place-items: center;
            color: var(--primary);
            font-weight: 950;
            flex: 0 0 auto;
        }
        .name-text{
            font-weight: 950;
            color: var(--text);
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 260px;
        }
        .name-tag{
            font-size: 11px;
            color: var(--muted);
            border: 1px solid var(--border);
            padding: 5px 8px;
            border-radius: 999px;
            background: #fff;
            flex: 0 0 auto;
        }

        .drawer-empty{
            padding: 18px;
            border: 1px dashed var(--border);
            border-radius: 14px;
            color: var(--muted);
            text-align: center;
            background: #fff;
        }

        /* Prevent background scrolling when drawer is open */
        body.drawer-lock{ overflow: hidden; }
    </style>

    <div class="page-wrap">
        <div class="container">

            @php
                $total = array_sum($newCustomers);
                $days = count($newCustomers);
                $dailyAvg = $days > 0 ? round($total / $days) : 0;
                $peak = $days > 0 ? max($newCustomers) : 0;

                $bestDay = null;
                if ($days > 0) {
                    foreach ($newCustomers as $dt => $ct) {
                        if ($ct === $peak) { $bestDay = $dt; break; }
                    }
                }
            @endphp

            <!-- Header -->
            <div class="header">
                <div>
                    <h1>Customer Registrations</h1>
                    <p>Last 30 days • Daily registrations & customer list per day</p>
                </div>

                <div class="pill" title="Range">
                    <i class="fa-regular fa-calendar"></i>
                    Last 30 days
                </div>
            </div>

            <!-- KPI cards -->
            <div class="kpi-grid">
                <div class="kpi">
                    <div>
                        <div class="label"><i class="fas fa-user-plus"></i> New Customers</div>
                        <div class="sub">Total signups in range</div>
                    </div>
                    <div class="right">
                        <div class="value">{{ $total }}</div>
                    </div>
                </div>

                <div class="kpi">
                    <div>
                        <div class="label"><i class="fa-solid fa-chart-line"></i> Daily Average</div>
                        <div class="sub">Avg per day</div>
                    </div>
                    <div class="right">
                        <div class="value">{{ $dailyAvg }}</div>
                    </div>
                </div>

                <div class="kpi">
                    <div>
                        <div class="label"><i class="fa-solid fa-bolt"></i> Peak Count</div>
                        <div class="sub">Highest single day</div>
                    </div>
                    <div class="right">
                        <div class="value">{{ $peak }}</div>
                    </div>
                </div>

                <div class="kpi">
                    <div>
                        <div class="label"><i class="fa-solid fa-crown"></i> Best Day</div>
                        <div class="sub">{{ $bestDay ? \Carbon\Carbon::parse($bestDay)->format('M d, Y') : '—' }}</div>
                    </div>
                    <div class="right">
                        <div class="value">{{ $bestDay ? $peak : 0 }}</div>
                    </div>
                </div>
            </div>

            <!-- Daily detail -->
            <div class="section">
                <div class="section-title">
                    <h2><i class="fa-solid fa-list" style="color:var(--primary)"></i> Daily Details</h2>
                    <div class="pill"><i class="fa-solid fa-filter"></i> Search & Filter</div>
                </div>

                @if($days > 0)
                    @php $avgCount = $total / $days; @endphp

                    <div class="controls">
                        <input id="dailySearch" class="input" type="text" placeholder="Search by date (e.g. Dec, Monday)..." />
                        <select id="dailyFilter" class="select">
                            <option value="all">All</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    <div class="daily-wrap" id="dailyWrap">
                        @foreach(array_reverse($newCustomers, true) as $date => $count)
                            @php
                                $dayName = \Carbon\Carbon::parse($date)->format('l');
                                $formattedDate = \Carbon\Carbon::parse($date)->format('M d, Y');

                                if ($count >= $avgCount * 1.2) $category = 'high';
                                elseif ($count >= $avgCount * 0.8) $category = 'medium';
                                else $category = 'low';
                            @endphp

                            <div class="row {{ $category }}"
                                 onclick="showCustomers('{{ $date }}', '{{ $formattedDate }}')"
                                 data-category="{{ $category }}"
                                 data-search="{{ strtolower($formattedDate . ' ' . $dayName) }}">
                                <div class="date">
                                    <div class="d">{{ $formattedDate }}</div>
                                    <div class="w">{{ $dayName }}</div>
                                </div>

                                <div class="badge" title="New customers">
                                    <span class="dot"></span>
                                    <span>{{ $count }}</span>
                                </div>

                                <div class="meta">
                                    vs avg: {{ $dailyAvg > 0 ? (round(($count / $dailyAvg) * 100) . '%') : '—' }}
                                    <div class="hint"><i class="fa-solid fa-arrow-right"></i> View names</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <script>
                        (function(){
                            const searchEl = document.getElementById('dailySearch');
                            const filterEl = document.getElementById('dailyFilter');
                            const wrap = document.getElementById('dailyWrap');
                            if(!searchEl || !filterEl || !wrap) return;

                            function apply(){
                                const q = (searchEl.value || '').toLowerCase().trim();
                                const cat = filterEl.value;

                                [...wrap.querySelectorAll('.row')].forEach(row => {
                                    const rowCat = row.getAttribute('data-category');
                                    const hay = row.getAttribute('data-search') || '';
                                    const matchText = !q || hay.includes(q);
                                    const matchCat = (cat === 'all') || (rowCat === cat);
                                    row.style.display = (matchText && matchCat) ? '' : 'none';
                                });
                            }

                            searchEl.addEventListener('input', apply);
                            filterEl.addEventListener('change', apply);
                        })();
                    </script>
                @else
                    <div class="no-data">No customer registration data available for the last 30 days.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Drawer Backdrop + Drawer -->
    <div id="drawerBackdrop" class="drawer-backdrop" onclick="closeCustomers()"></div>

    <div id="customerDrawer" class="drawer" role="dialog" aria-modal="true" aria-labelledby="drawerTitle">
        <div class="drawer-header">
            <div class="drawer-top">
                <h3 class="drawer-title" id="drawerTitle">Customers Registered</h3>
                <button class="drawer-close" type="button" onclick="closeCustomers()">Close</button>
            </div>

            <div class="drawer-sub">
                <span class="count-pill" id="drawerDatePill"><i class="fa-regular fa-calendar"></i> —</span>
                <span class="count-pill" id="drawerCountPill"><i class="fa-solid fa-users"></i> 0 customers</span>
            </div>

            <input id="customerSearch" class="drawer-search" type="text" placeholder="Search customer name..." />
        </div>

        <div class="drawer-body">
            <div id="customerList" class="name-grid"></div>
        </div>
    </div>

    <script>
        const customersByDate = @json($customersByDate);

        const drawer   = document.getElementById('customerDrawer');
        const backdrop = document.getElementById('drawerBackdrop');
        const listEl   = document.getElementById('customerList');
        const datePill = document.getElementById('drawerDatePill');
        const countPill= document.getElementById('drawerCountPill');
        const searchEl = document.getElementById('customerSearch');

        let currentNames = [];

        function normalizeNames(data){
            // supports:
            // 1) ["A","B"]
            // 2) [{customer_name:"A"}, ...]
            if(!data) return [];
            if(Array.isArray(data) && data.length === 0) return [];
            if(Array.isArray(data) && typeof data[0] === 'string') return data.filter(Boolean);
            if(Array.isArray(data) && typeof data[0] === 'object') return data.map(x => x.customer_name).filter(Boolean);
            return [];
        }

        function initials(name){
            const parts = String(name || '').trim().split(/\s+/).filter(Boolean);
            if(parts.length === 0) return '?';
            if(parts.length === 1) return parts[0].slice(0,2).toUpperCase();
            return (parts[0][0] + parts[parts.length-1][0]).toUpperCase();
        }

        function renderNames(names){
            listEl.innerHTML = '';

            if(!names.length){
                listEl.innerHTML = `<div class="drawer-empty">No customers registered on this day.</div>`;
                return;
            }

            const frag = document.createDocumentFragment();
            names.forEach((name, idx) => {
                const row = document.createElement('div');
                row.className = 'name-item';
                row.innerHTML = `
                    <div class="name-left">
                        <div class="avatar">${initials(name)}</div>
                        <div class="name-text" title="${name}">${name}</div>
                    </div>
                    <div class="name-tag">#${idx + 1}</div>
                `;
                frag.appendChild(row);
            });
            listEl.appendChild(frag);
        }

        function openCustomers(dateKey, prettyDate){
            const raw = customersByDate[dateKey];
            currentNames = normalizeNames(raw);

            datePill.innerHTML  = `<i class="fa-regular fa-calendar"></i> ${prettyDate || dateKey}`;
            countPill.innerHTML = `<i class="fa-solid fa-users"></i> ${currentNames.length} customer${currentNames.length === 1 ? '' : 's'}`;

            searchEl.value = '';
            renderNames(currentNames);

            backdrop.style.display = 'block';
            drawer.classList.add('open');
            document.body.classList.add('drawer-lock');

            setTimeout(() => searchEl.focus(), 10);
        }

        function closeCustomers(){
            drawer.classList.remove('open');
            backdrop.style.display = 'none';
            document.body.classList.remove('drawer-lock');
        }

        // Search inside drawer
        searchEl.addEventListener('input', function(){
            const q = (this.value || '').toLowerCase().trim();
            if(!q) return renderNames(currentNames);

            const filtered = currentNames.filter(n => String(n).toLowerCase().includes(q));
            renderNames(filtered);
        });

        // ESC to close
        document.addEventListener('keydown', (e) => {
            if(e.key === 'Escape') closeCustomers();
        });

        // expose for onclick
        function showCustomers(dateKey, prettyDate){
            openCustomers(dateKey, prettyDate);
        }
        window.showCustomers = showCustomers;
        window.closeCustomers = closeCustomers;
    </script>
</x-app-layout>
