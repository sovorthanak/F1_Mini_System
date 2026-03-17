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
                    <h4>Permissions
                        <a href="/administration/permissions/create" class="btn btn-primary float-end">Add Permission</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permission as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <a href="{{ url('/administration/permissions/'.$permission->id.'/edit') }}" class="btn btn-success" style="padding: 0.2rem 0.4rem; font-size: 0.75rem;"><i class="fas fa-edit"></i></a>
                                        <a href="{{ url('/administration/permissions/'.$permission->id.'/delete') }}" class="btn btn-danger" style="padding: 0.2rem 0.4rem; font-size: 0.75rem;"><i class="fa-solid fa-trash"></i></a>
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

@endsection