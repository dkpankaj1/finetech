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
                        <li class="breadcrumb-item"><a href="{{ route('finetech.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Show</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body d-flex justify-content-end">
            <x-button text="Back" icon="back" variant="dark" href="{{ route('finetech.users.index') }}" />
            <x-button text="Edit" icon="edit" variant="info" href="{{ route('finetech.users.edit', $user) }}" />
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">User Details</h4>
        </div>
        <div class="card-body">

            <div class="row justify-content-center">

                {{-- Avatar --}}
                <div class="col-md-3 text-center mb-4">
                    <img src="{{ $user->profileImage() }}" alt="{{ $user->name }}"
                        class="rounded-circle img-thumbnail" style="width:130px;height:130px;object-fit:cover;">
                    <div class="mt-2">
                        @foreach ($user->getRoleNames() as $role)
                            <span class="badge bg-primary">{{ $role }}</span>
                        @endforeach
                    </div>
                </div>

                {{-- Info --}}
                <div class="col-md-5 mb-4">
                    <table class="table table-borderless table-sm">
                        <tbody>
                            <tr>
                                <th style="width:40%">Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Email Verified</th>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-success">
                                            Verified &mdash; {{ $user->email_verified_at->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">Not Verified</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge bg-primary">{{ $role }}</span>
                                    @empty
                                        <span class="text-muted">No role assigned</span>
                                    @endforelse
                                </td>
                            </tr>
                            <tr>
                                <th>Joined</th>
                                <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ $user->updated_at->diffForHumans() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
