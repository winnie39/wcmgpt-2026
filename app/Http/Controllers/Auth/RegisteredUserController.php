<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmail;
use App\Models\Referral;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string',  'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
        ]);


        $referrerCode = $request->referral_code;
        $referrer = null;

        if ($referrerCode) {

            $referrer = Referral::where('code', 'like', $referrerCode)->first();
        }

        if ($referrer) {
            $user->referral()->create([
                'code' => Str::random(8),
                'referrer_id' => $referrer->user_id,
            ]);
        } else {
            $user->referral()->create([
                'code' => Str::random(8)
            ]);
        }



        $user->wallet()->create();
        $user->trade()->create(['status' => false]);

        $user->kyc()->create();

        $code  = fake()->randomNumber(5);
        session(['verify' => $code]);

        Auth::login($user);

        return redirect('/?modal=true');
    }
}
