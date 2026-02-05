{{-- <x-guest-layout>
    <div class="main-container">

        <div class="mb-4 text-sm text-white">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <div class="form-group float-label">
                    <input type="text" class="form-control " value="" name="email">
                    <label class="form-control-label "><i class="las la-user"></i>
                        Email</label>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col">
                    <button type="submit" id="recaptcha" class="btn loginBtn rounded btn-block shadow">
                        {{ __('Email Password Reset Link') }}</button>
                </div>
            </div>


        </form>
    </div>
</x-guest-layout> --}}


@component('layouts.guest')
    <div class="main-container">
        <form method="POST" action="{{ route('password.email') }}" class="login-form mt-50 verify-gcaptcha">
            @csrf
            <div class="container h-100 ">
                <div class="row h-100">
                    <div class="col-12 align-self-center mb-4">
                        <div class="row justify-content-center">
                            <div class="col-11 col-sm-7 col-md-6 col-lg-5 col-xl-4">
                                <div class="mb-4 text-sm text-white">
                                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                                </div>

                                <!-- Session Status -->
                                <x-auth-session-status class="mb-4" :status="session('status')" />

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <!-- Email Address -->
                                    <div>
                                        <div class="form-group float-label">
                                            <input type="text" class="form-control " value="" name="email">
                                            <label class="form-control-label "><i class="las la-user"></i>
                                                Email</label>
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />

                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col">
                                            <button type="submit" id="recaptcha"
                                                class="btn loginBtn rounded btn-block shadow">
                                                {{ __('Email Password Reset Link') }}</button>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endcomponent
