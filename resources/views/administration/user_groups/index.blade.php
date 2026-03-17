@extends('layouts.administration-nav')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>Roles</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="all-cust-table">
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Number</th>
                                <th>Members</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->users->count() }}</td>
                                    <td>
                                        @foreach ($role->users as $user)
                                            <label class="badge bg-primary d-inline-block me-1 mb-1" style="font-size: 14px;">
                                                {{ $user->name }}
                                            </label>
                                        @endforeach
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
<!-- DataTables Initialization Only -->
<script>
    $(document).ready(function () {
        try {
            $('#all-cust-table').DataTable({
                paging: true,
                pagingType: "full_numbers",
                lengthChange: false,
                pageLength: 15,
                dom: '<"top"fip><"clear">',
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
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