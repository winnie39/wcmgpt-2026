<x-guest-layout>

    <div class="main-container">
        <div class="container h-100 ">
            <div class="row h-100">
                <div class="col-12 align-self-center mb-4">
                    <div class="row justify-content-center">
                        <div class="col-11 col-sm-7 col-md-6 col-lg-5 col-xl-4">
                            <form method="POST" action="verify-email">
                                <h2 class="font-weight-normal mb-5 text-center text-primary"><b>Verify email</b>
                                </h2>
                                <div class="mb-4 text-sm text-white">
                                    {{ __('Thanks for signing up! Before getting started, please check your email for a verification code. Once received, enter the code on our platform to complete the process.
                                                                                                            ') }}
                                </div>

                                @if (session('status') == 'verification-link-sent')
                                    <div class="mb-4 font-medium text-sm text-green-600">
                                        {{ __('A new verification code has been sent to the email address you provided during registration.') }}
                                    </div>
                                @endif


                                @if (session('status') == 'failed')
                                    <div class="mb-4 font-medium text-sm text-red-600">
                                        {{ __('The email verification code does not match.') }}
                                    </div>
                                @endif

                                <div class="form-group float-label position-relative">
                                    <input type="text" class="form-control " name="verification_code">
                                    <label class="form-control-label "><i class="las la-unlock-alt"></i>
                                        Verification code</label>
                                    <x-input-error :messages="$errors->get('verification_code')" class="mt-2" />
                                </div>

                                <div class="mt-4 flex items-center justify-between ">



                                    <div>
                                        <div class="col">
                                            <a type="type" id="recaptcha" href="{{ route('verification.send') }}"
                                                class="btn loginBtn rounded btn-block shadow text-white">
                                                {{ __('Resend Verification Email') }}
                                            </a>
                                        </div>
                                    </div>


                                    @csrf
                                    <div class="col">
                                        <button type="submit" id="recaptcha"
                                            class="btn loginBtn rounded btn-block shadow text-white">
                                            {{ __('Verify email') }}</button>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
