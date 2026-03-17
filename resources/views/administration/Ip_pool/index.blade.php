@extends('layouts.administration-nav')

@section('content')
<style>
    .badge-toggle {
        font-size: 0.85rem;
        border: none;
        padding: 5px 12px;
        border-radius: 20px;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }
    .badge-toggle.active { background-color: #28a745; }
    .badge-toggle.active:hover { background-color: #218838; }
    .badge-toggle.inactive { background-color: #dc3545; }
    .badge-toggle.inactive:hover { background-color: #c82333; }

    /* Modal Styles (same as your Locations page) */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .modal-content {
        background-color: #fff;
        margin: 8% auto;
        padding: 20px;
        border-radius: 10px;
        width: 55%;
    }
    @media (max-width: 992px){
        .modal-content{ width: 92%; margin: 14% auto; }
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }
    .close:hover { color: red; }

    .hint-box{
        background:#f8fafc;
        border:1px solid #e5e7eb;
        border-radius:10px;
        padding:10px 12px;
        font-size: 13px;
        color:#0f172a;
    }
    .hint-box code{ font-size: 12px; }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>
                        IP Pools (CIDR)
                        <button class="btn btn-primary float-end"
                            onclick="window.location.href='{{ route('ip.pools.create') }}'">
                            Add CIDR Pool
                        </button>
                    </h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-striped" id="pools-table">
                        <thead>
                            <tr>
                                <th style="text-align:center;">ID</th>
                                <th style="text-align:center;">Network Name</th>
                                <th style="text-align:center;">Network Description</th>
                                <th style="text-align:center;">Prefix</th>
                                <th style="text-align:center;">Visible</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pools as $pool)
                                <tr>
                                    <td style="text-align:center;">{{ $pool->id }}</td>

                                    <td>
                                        <a href="{{ route('ip.pools.showIpInventory', ['pool_id' => $pool->id]) }}" >
                                            <b>{{ $pool->name  }}</b>
                                        </a>
                                    </td>
                                    <td>{{ $pool->description ?? "-" }}</td>

                                    <td>{{ $pool->cidr }}</td>
                                    <td>{{ $pool->is_active ? 'Yes' : 'No' }}</td>

                                    <td style="text-align:center;">
                                        <a href= "{{ route ('ip.pools.edit', ['ipPool' => $pool->id]) }}">
                                            Edit
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

    <script>
        $(document).ready(function () {
            try {
                $('#pools-table').DataTable({
                    paging: true,
                    pagingType: "full_numbers",
                    lengthChange: false,
                    pageLength: 15,
                    dom: '<"top"fip><"clear">',
                    searching: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    language: {
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "No entries available",
                        emptyTable: "No data available in the table",
                        paginate: {
                            first: "First",
                            last: "Last",
                            next: "Next",
                            previous: "Previous"
                        }
                    }
                });
            } catch (e) {
                console.error("DataTable initialization error:", e);
            }
        });
    </script>
@endsection
