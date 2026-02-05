@component('layouts.app')
    {{-- <div class="main-container"> --}}
    <div class="container">


        <form id="profileSetting" class="user-profile-form" action="/password" method="post">
            @csrf

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="subtitle mb-0">
                        <div class="avatar avatar-40 bg-success-light text-success rounded mr-2"><span
                                class="material-icons vm">account_circle</span></div>
                        Change password
                    </h6>
                </div>

                <div class="card-body">

                    <div class="form-group float-label active">
                        <input type="text" class="form-control" id="current_password" name="current_password">
                        <label class="form-control-label">Current password</label>
                        <x-input-error :messages="$errors->get('current_password')" class="text-start mt-2" />
                    </div>
                    <div class="form-group float-label active">
                        <input type="text" class="form-control" id="password" name="password">
                        <label class="form-control-label">New password</label>
                        <x-input-error :messages="$errors->get('password')" class="text-start mt-2" />

                    </div>

                    <div class="form-group float-label active">
                        <input type="tel" class="form-control" id="password_confirmation" name="password_confirmation">
                        <label class="form-control-label">Password Confirmation</label>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="text-start mt-2" />

                    </div>


                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-block btn-default rounded" value="Update Information">
                </div>
            </div>
        </form>


    </div>
    {{-- </div> --}}
@endcomponent
