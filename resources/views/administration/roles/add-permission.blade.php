<x-app-layout>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                
                <div class="card">
                    <div class="card-header">
                        <h4>Edit/Add Permission for : {{ $role->name }}
                            <a href="/administration/roles" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/administration/roles/'.$role->id.'/give-perm') }}" method="post">
                            @csrf
                            @method('put')
                            
                            @error('permission')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            
                            <h3 for="">Permission</h3>

                            <div class="row">
                            @foreach ($perm as $perm)
                            <div class="col-mb-3">
                                <label>
                                    <input 
                                        type="checkbox" 
                                        value="{{ $perm->name }}" 
                                        name="permission[]" 
                                        class=""
                                        {{ in_array($perm->id, $rolePerm->toArray()) ? 'checked' : '' }}
                                    />
                                    {{ $perm->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update Permission</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>