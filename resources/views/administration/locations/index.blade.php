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
        background-color: #28a745; /* Green */
    }

    .badge-toggle.active:hover {
        background-color: #218838;
    }

    .badge-toggle.inactive {
        background-color: #dc3545; /* Red */
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
                        Locations
                        <button class="btn btn-primary float-end" onclick="document.getElementById('locationModal').style.display='block'">Add Location</button>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="locations-table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Description</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($locations as $location)
                                <tr>
                                    <td>{{ $location->id }}</td>
                                    <td>{{ $location->name }}</td>
                                    <td>{{ $location->description }}</td>
                                    <td>
                                        <form action="{{ route('locations.toggleStatus', $location->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="badge-toggle {{ $location->status ? 'active' : 'inactive' }}">
                                                {{ $location->status ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('locations.destroy', $location->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this location?');" style="display:inline;">
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

<!-- Add Location Modal -->
<div id="locationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('locationModal').style.display='none'">&times;</span>
        <h4>Add New Location</h4>
        <br>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('locations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name">Location Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" id="description" placeholder="Optional description...">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3 text-end">
                <button type="submit" class="btn btn-success">Add Location</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Close modal if user clicks outside content
    window.onclick = function(event) {
        const modal = document.getElementById('locationModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Optional: If there are validation errors, open modal automatically on page load
    @if ($errors->any())
        document.getElementById('locationModal').style.display = 'block';
    @endif
</script>

<script>
    $(document).ready(function () {
        try {
            $('#locations-table').DataTable({
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
