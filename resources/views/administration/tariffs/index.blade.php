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

    .badge-toggle.active {
        background-color: #28a745;
    }

    .badge-toggle.active:hover {
        background-color: #218838;
    }

    .badge-toggle.inactive {
        background-color: #dc3545;
    }

    .badge-toggle.inactive:hover {
        background-color: #c82333;
    }

    /* Modal Styles */
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
        margin: 10% auto;
        padding: 20px;
        border-radius: 10px;
        width: 50%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: red;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>
                        Tariffs
                        <button class="btn btn-primary float-end" onclick="document.getElementById('tariffModal').style.display='block'">
                            Add Tariff
                        </button>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="tariff-table">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tariffs as $tariff)
                                <tr>
                                    <td>{{ $tariff->id }}</td>
                                    <td>{{ $tariff->name }}</td>
                                    <td>{{ $tariff->description }}</td>
                                    <td>
                                        <form action="{{ route('tariffs.toggleStatus', $tariff->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="badge-toggle {{ $tariff->status ? 'active' : 'inactive' }}">
                                                {{ $tariff->status ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('tariffs.destroy', $tariff->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this tariff?');"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" style="padding: 0.2rem 0.4rem; font-size: 0.75rem;">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
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

<!-- Modal -->
<div id="tariffModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('tariffModal').style.display='none'">&times;</span>
        <h4>Add New Tariff</h4>
        <br>
        <form action="{{ route('tariffs.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name">Tariff Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description" placeholder="Optional description..."></textarea>
            </div>
            <div class="mb-3 text-end">
                <button type="submit" class="btn btn-success">Add Tariff</button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script>
    window.onclick = function (event) {
        const modal = document.getElementById('tariffModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
</script>

<script>
    $(document).ready(function () {
        try {
            $('#tariff-table').DataTable({
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
