@component('layouts.app')
    {{-- <div class="main-container"> --}}
    <div class="py-4">

        <div class="container">


            <form id="profileSetting" class="user-profile-form" action="/profile" method="post" enctype="multipart/form-data">
                @csrf

                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="subtitle mb-0">
                            <div class="avatar avatar-40 bg-success-light text-success rounded mr-2"><span
                                    class="material-icons vm">account_circle</span></div>
                            User Informations
                        </h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group float-label active">
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ auth()->user()->name }}">
                            <label class="form-control-label">Name</label>
                            <x-input-error :messages="$errors->get('name')" class="text-start mt-2" />

                        </div>
                        <div class="form-group float-label active">
                            <input type="text" class="form-control" id="email" name="email"
                                value="{{ auth()->user()->email }}">
                            <label class="form-control-label">Email</label>
                            <x-input-error :messages="$errors->get('email')" class="text-start mt-2" />

                        </div>

                        <div class="form-group float-label active">
                            <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                value="{{ auth()->user()->phone_number }}">
                            <input type="hidden" name="country" id="country" class="form-control d-none" value="Kenya">
                            <label class="form-control-label">Mobile Number</label>
                            <x-input-error :messages="$errors->get('phone_number')" class="text-start mt-2" />

                        </div>


                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-block btn-default rounded" value="Update Information">
                    </div>
                </div>
            </form>

            <form id="addressSetting" class="user-profile-form" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="3SCJ2vmTMirv1d84UbtdQiQeoDNRu9YAStxQKo6n">

            </form>

        </div>
    </div>

    {{-- </div> --}}
@endcomponent
