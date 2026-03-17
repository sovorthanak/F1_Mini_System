<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edite Permissions
                            <a href="/administration/permissions" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/administration/permissions/'.$permission->id) }}" method="post">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label for="permission-name">Permission Name</label>
                                <input type="text" id="permission-name" value="{{ $permission->name }}" name="name" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>