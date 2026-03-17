<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit User : {{ $user->name }}
                            <a href="/administration/users" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/administration/users/'.$user->id) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="">User's Name</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Email</label>
                                <input type="text" name="email" readonly value="{{ $user->email }}" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="">Password</label>
                                <input type="text" name="password" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label for="">Roles</label>
                                <br>
                                <br>
                                {{-- <select name="roles[]" class="form-control" multiple>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select> --}}
                                @foreach ($roles as $role)
                                <div class="col-mb-3">
                                    <label>
                                        <input 
                                            type="checkbox" 
                                            value="{{ $role }}" 
                                            name="roles[]" 
                                            class=""
                                            {{ in_array($role, $userRoles) ? 'checked' : '' }}
                                        />
                                        {{ $role }}
                                    </label>
                                </div>
                                @endforeach
                                @error('roles')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>