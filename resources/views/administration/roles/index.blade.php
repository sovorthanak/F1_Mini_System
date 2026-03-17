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
                    <h4>Roles



                    @can('create role')
                        <a href="/administration/roles/create" class="btn btn-primary float-end">Add Role</a>
                    @endcan




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
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <a href="{{ url('/administration/roles/'.$role->id.'/give-perm') }}" class="btn btn-warning">Add / Edit Role Permission</a>
                                        
                                        @can('edit role')
                                            <a href="{{ url('/administration/roles/'.$role->id.'/edit') }}" class="btn btn-success">Edit</a>
                                        @endcan

                                        @can('delete role')
                                            <a href="{{ url('/administration/roles/'.$role->id.'/delete') }}" class="btn btn-danger">Delete</a>
                                        @endcan

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