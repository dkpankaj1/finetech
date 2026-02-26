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
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Create Role</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4"> 
                    <div class="mb-3">
                        <x-input-label name="role_name" class="">Role Name</x-input-label>
                    </div>
                </div>
                <div class="col-md-8"></div>
            </div>
        </div>
    </div>

</x-app-layout>