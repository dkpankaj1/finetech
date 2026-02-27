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
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('finetech.users.update',$user) }}" method="POST">
        @csrf
        @method('put')

        <div class="card">
            <div class="card-body d-flex justify-content-end">
                <x-button text="Back" icon="back" variant="dark" href="{{ route('finetech.users.index') }}" />
                <x-button text="Update" icon="update" />
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Update User</h4>
            </div>
            <div class="card-body">

                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3">
                        <x-input-label name="name" text="Name" />
                        <x-input-field name="name" placeholder="Enter Name" value="{{ $user->name }}" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <x-input-label name="email" text="Email" />
                        <x-input-field name="email" type="email" placeholder="example@email.com" value="{{ $user->email }}" />
                    </div>
                </div>

                <div class="row justify-content-center mb-2">
                    <div class="col-md-8">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="togglePassword" onchange="togglePasswordFields(this)">
                            <label class="form-check-label fw-bold" for="togglePassword">Change Password</label>
                        </div>
                    </div>
                </div>

                <div id="passwordFields" class="row justify-content-center" style="display:none !important;">
                    <div class="col-md-4 mb-3">
                        <x-input-label name="password" text="New Password" />
                        <x-input-field name="password" type="password" placeholder="Enter new password" disabled />
                    </div>
                    <div class="col-md-4 mb-3">
                        <x-input-label name="password_confirmation" text="Confirm Password" />
                        <x-input-field name="password_confirmation" type="password" placeholder="Re-enter new password" disabled />
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 mb-3">
                        <x-input-label name="role" text="Role Name" />
                        <select name="role" class="form-select">
                            <option value="">-- Select Role ---</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role', $userRole) === $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
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

    <script>
        function togglePasswordFields(checkbox) {
            const section = document.getElementById('passwordFields');
            const inputs = section.querySelectorAll('input');
            if (checkbox.checked) {
                section.style.removeProperty('display');
                inputs.forEach(i => i.removeAttribute('disabled'));
            } else {
                section.style.setProperty('display', 'none', 'important');
                inputs.forEach(i => i.setAttribute('disabled', 'disabled'));
            }
        }

        @if ($errors->hasAny(['password', 'password_confirmation']))
            document.addEventListener('DOMContentLoaded', function () {
                const toggle = document.getElementById('togglePassword');
                toggle.checked = true;
                togglePasswordFields(toggle);
            });
        @endif
    </script>

</x-app-layout>