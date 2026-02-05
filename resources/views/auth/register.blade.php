@component('layouts.guest')
    <div class="main-container">
        <form class="verify-gcaptcha mt-4" action="/register" method="POST">
            @csrf
            <div class="container h-100 ">
                <div class="row h-100">
                    <div class="col-12 align-self-center mb-4">
                        <div class="row justify-content-center">
                            <div class="col-11 col-sm-7 col-md-6 col-lg-5 col-xl-4">
                                <h2 class="font-weight-normal mb-5 text-center text-primary"><b>Sign Up</b></h2>

                                <div class="form-group float-label">
                                    <input class="form-control  checkUser" id="name" name="name" type="text">
                                    <label class="form-control-label "><i class="las la-user-tag"></i> Name</label>
                                    <x-input-error :messages="$errors->get('name')" class="text-start mt-2" />

                                </div>
                                <div class="form-group float-label">
                                    <input class="form-control  checkUser" id="email" name="email" type="text">
                                    <label class="form-control-label "><i class="las la-user-tag"></i> Email</label>
                                    <x-input-error :messages="$errors->get('email')" class="text-start mt-2" />
                                </div>

                                <input value="{{ request()->input('ref') }}" class="form-control  checkUser"
                                    id="referral_code" name="referral_code" type="hidden">

                                <div class="form-group float-label">
                                    <input class="form-control  checkUser" id="phone_number" name="phone_number"
                                        type="text">
                                    <label class="form-control-label "><i class="las la-envelope-open"></i> Phone
                                        number</label>
                                    <x-input-error :messages="$errors->get('phone_number')" class="text-start mt-2" />
                                </div>
                                <div class="form-group float-label position-relative">
                                    <input class="form-control " id="password" name="password" type="password">
                                    <label class="form-control-label "><i class="las la-unlock-alt"></i> Password</label>
                                    <x-input-error :messages="$errors->get('password')" class="text-start mt-2" />
                                </div>
                                <div class="form-group float-label position-relative">
                                    <input class="form-control" id="password_confirmation" name="password_confirmation"
                                        type="password" autocomplete="new-password">
                                    <label class="form-control-label "><i class="las la-unlock-alt"></i> Confirm
                                        Password</label>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-start mt-2" />
                                </div>
                                <div class="form-group float-label position-relative">
                                    <div class="custom-control custom-switch">
                                        <input class="custom-control-input" id="agree" name="agree" type="checkbox">
                                        <label class="custom-control-label" for="agree"> I agree with</label>
                                        <a class="text--base">Privacy and
                                            Policy</a>
                                        <a class="text--base" href="/privacy-policy">Payment Policy</a>
                                    </div>
                                </div>
                                <button class="btn loginBtn rounded btn-block" id="recaptcha"
                                    type="submit">Register</button>
                                <div class="row justify-content-center my-4">
                                    <div class="col text-center">
                                        <p class="text-white mb-1">Already have an account?</p>
                                        <a href="/login" class="text-white mb-3 pt-0">
                                            <b>Sign In</b>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endcomponent
