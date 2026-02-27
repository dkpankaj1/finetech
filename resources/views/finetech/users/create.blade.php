<x-app-layout>

    <div class="py-3 py-lg-4">
        <div class="row">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">Users</h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('finetech.users.index') }}">User</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.users.store') }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-body d-flex justify-content-end">
                <x-button text="Back" icon="back" variant="dark" href="{{ route('finetech.users.index') }}" />
                <x-button text="Create" icon="add" />
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create New User</h4>
            </div>
            <div class="card-body">

                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <x-input-label name="name" text="Name" />
                        <x-input-field name="name" placeholder="Enter Name" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <x-input-label name="email" text="Email" />
                        <x-input-field name="email" type="email" placeholder="example@email.com" />
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <x-input-label name="password" text="Password" />
                        <x-input-field name="password" type="password" placeholder="Enter Password" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <x-input-label name="password_confirmation" text="Password" />
                        <x-input-field name="password_confirmation" type="password" placeholder="ReEnter Password" />
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 mb-3">
                        <x-input-label name="role" text="Role Name" />
                        <select name="role" class="form-select">
                            <option value="">-- Select Role ---</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback d-block my-1 text-danger">✖ {{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>
        </div>


    </form>

</x-app-layout>