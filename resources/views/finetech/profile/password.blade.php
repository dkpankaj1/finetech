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

    <form action="{{ route('finetech.profile.password') }}" method="post">
        @csrf
        @method('patch')

        <div class="card" style="font-weight:bold">

            <div class="card-body">

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">

                        <div class="mb-3">
                            <x-input-label name="current_password" text="Current Password" />
                            <x-input-field name="current_password" type="password" placeholder="Current Password" />
                        </div>

                        <div class="mb-3">
                            <x-input-label name="password" text="New Password" />
                            <x-input-field name="password" type="password" placeholder="New Password" />
                        </div>

                        <div class="mb-3">
                            <x-input-label name="password_confirmation" text="Confirm Password" />
                            <x-input-field name="password_confirmation" type="password"
                                placeholder="Confirm Password" />
                        </div>

                        <hr>

                        <button class="btn btn-primary px-5">Update</button>

                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        </div>
    </form>

</x-app-layout>