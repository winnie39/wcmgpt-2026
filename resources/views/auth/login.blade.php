@component('layouts.guest')
    <div class="main-container">
        <form id="loginForm" method="POST" action="/login" class="login-form mt-50 verify-gcaptcha">
            @csrf
            <div class="container h-100 ">
                <div class="row h-100">
                    <div class="col-12 align-self-center mb-4">
                        <div class="row justify-content-center">
                            <div class="col-11 col-sm-7 col-md-6 col-lg-5 col-xl-4">
                                <h2 class="font-weight-normal mb-5 text-center text-primary"><b>Login</b>
                                </h2>
                                <div class="form-group float-label">
                                    <input type="text" class="form-control " value="" name="email">
                                    <label class="form-control-label "><i class="las la-user"></i>
                                        Email</label>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                                </div>
                                <div class="form-group float-label position-relative">
                                    <input type="password" class="form-control " name="password">
                                    <label class="form-control-label "><i class="las la-unlock-alt"></i>
                                        Password</label>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                                </div>

                                <div class="text-end  pb-2">
                                    <a href="/forgot-password" class="  text-blue-600">
                                        Forgot password?
                                    </a>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col">
                                        <button type="submit" id="recaptcha"
                                            class="btn loginBtn rounded btn-block shadow">Login</button>
                                    </div>
                                </div>
                                <div class="row justify-content-center my-4">
                                    <div class="col text-center">
                                        <p class="text-white mb-1">You don't have any Account?</p>
                                        <a href="/register" class="text-white mb-3 pt-0 select-none">
                                            <b>Sign Up</b>
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
