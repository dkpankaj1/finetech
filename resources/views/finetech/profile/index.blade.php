<x-app-layout>

    <div class="py-3 py-lg-4">
        <div class="row">
            <div class="col-lg-6">
                <h4 class="page-title mb-0">Dashboard</h4>
            </div>
            <div class="col-lg-6">
                <div class="d-none d-lg-block">
                    <ol class="breadcrumb m-0 float-end">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="align-items-center">
                <div class="d-flex align-items-center">
                    <div class="overflow-hidden ms-4">
                        <h4 class="m-0 text-dark fs-20">{{ $user->name }}</h4>
                        <p class="my-1 text-muted fs-16">{{ $user->email }}</p>
                    </div>
                </div>
                <hr>
                <a class="btn btn-primary" href="{{ route('finetech.profile.update') }}">Edit Profile</a>
            </div>


        </div>
    </div>

</x-app-layout>