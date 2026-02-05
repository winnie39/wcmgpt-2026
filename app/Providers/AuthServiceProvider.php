<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Mail\VerifyEmail as MailVerifyEmail;
use Filament\Notifications\Auth\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        $code  = fake()->randomNumber(5);

        session('verify', $code);



        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return Mail::to(auth()->user()->email)->send(new MailVerifyEmail(auth()->id(), $url));
        });
    }
}
