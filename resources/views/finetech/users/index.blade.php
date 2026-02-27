<x-app-layout>

    <div class="py-3 py-lg-4">
        <div class="row">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">Users</h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="{{ route('finetech.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body d-flex justify-content-end">
            <x-button icon="add" variant="dark" text="Add New" href="{{ route('finetech.users.create') }}" />
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Manage User</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Role</th>
                            <th>Last Update</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->getRoleNames() as $role)
                                        <span>{{ $role }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>
                                    <div class="d-flex">
                                        <x-button size="sm" icon="show" variant="primary"
                                            href="{{ route('finetech.users.show', $user) }}" text="Show" />
                                        <x-button size="sm" icon="edit" variant="info" text="Edit"
                                            href="{{ route('finetech.users.edit', $user) }}" />
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal"
                                            data-delete-url="{{ route('finetech.users.destroy', $user) }}"
                                            data-item-name="{{ $user->name }}">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- confirm delete modal --}}
    <x-confirm-delete-model modal-id="confirmDeleteModal" title="Delete User"
        message="Are you sure you want to delete this user? This action cannot be undone." />

</x-app-layout>