{{-- <x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}




@component('layouts.guest')
    <div class="main-container">
        <form method="POST" action="{{ route('password.store') }}" class="login-form mt-50 verify-gcaptcha">
            @csrf
            <div class="container h-100 ">
                <div class="row h-100">
                    <div class="col-12 align-self-center mb-4">
                        <div class="row justify-content-center">
                            <div class="col-11 col-sm-7 col-md-6 col-lg-5 col-xl-4">


                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <!-- Email Address -->
                                <div>
                                    <div class="form-group float-label">
                                        <input type="text" class="form-control " value="" name="email">
                                        <label class="form-control-label "><i class="las la-user"></i>
                                            Email</label>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />

                                    </div>
                                </div>

                                <div>
                                    <div class="form-group float-label">
                                        <input type="password" class="form-control " value="" name="password">
                                        <label class="form-control-label "><i class="las la-user"></i>
                                            New password</label>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                                    </div>
                                </div>


                                <div>
                                    <div class="form-group float-label">
                                        <input type="password" class="form-control " value=""
                                            name="password_confirmation">
                                        <label class="form-control-label "><i class="las la-user"></i>
                                            Confirm password</label>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col">
                                        <button type="submit" id="recaptcha" class="btn loginBtn rounded btn-block shadow">
                                            {{ __('Reset password') }}</button>
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
