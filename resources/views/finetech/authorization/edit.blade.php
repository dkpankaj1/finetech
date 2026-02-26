<x-app-layout>

    <div class="py-3 py-lg-4">
        <div class="row">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">Role & Permission</h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.authorization.index') }}">Role &
                                Permission</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.authorization.update', $role) }}" method="POST">
        @csrf
        @method('put')

        <div class="card">
            <div class="card-body d-flex justify-content-end">
                <x-button href="{{ route('finetech.authorization.index') }}" text="Cancle" variant="dark" icon="back"/>
                <x-button text="Update" icon="save" />
            </div>
        </div>

        <div class="row">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Role</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <x-input-label name="name" text="Role Name" />
                            <x-input-field name="name" placeholder="Enter RoleName" value="{{ old('name',$role->name) }}" />
                            @error('permissions')
                                <div class="invalid-feedback d-block my-1 text-danger">✖ {{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    @foreach ($permissionGroups as $key => $permissionGroup)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ $permissionGroup->name }}</h4>
                                </div>
                                <div class="card-body">
                                    @foreach ($permissionGroup->permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $permission->name }}"
                                                name="permissions[]" @if(in_array($permission->name, old('permissions',$hasPermissions) ?? []))
                                                checked @endif>
                                            <label class="form-check-label"
                                                for="flexCheckDefault">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>



    </form>

</x-app-layout>