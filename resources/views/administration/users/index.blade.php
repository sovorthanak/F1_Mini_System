@extends('layouts.administration-nav')

@section('content')
<style>
    /* Optional: Style for badge spacing */
    .badge {
        font-size: 0.85rem;
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
                        Users
                        <a href="/administration/users/create" class="btn btn-primary float-end">Add User</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="users-table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Email</th>
                                <th style="text-align: center;">Role</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $rolename)
                                                <label class="badge bg-primary mx-1">{{ $rolename }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('/administration/users/'.$user->id.'/edit') }}" class="btn btn-success btn-sm" style="padding: 0.2rem 0.4rem; font-size: 0.75rem;"><i class="fas fa-edit"></i></a>
                                        <a href="{{ url('/administration/users/'.$user->id.'/delete') }}" class="btn btn-danger btn-sm" style="padding: 0.2rem 0.4rem; font-size: 0.75rem;"><i class="fa-solid fa-trash"></i></a>
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

<!-- DataTable Script -->
<script>
    $(document).ready(function () {
        try {
            $('#users-table').DataTable({
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
