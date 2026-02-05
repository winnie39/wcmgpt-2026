<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\CountryHelper;
use App\Mail\KycCompleted;
use App\Mail\KycRejected;
use App\Mail\KycSubmission;
use App\Models\Country;
use App\Models\Kyc;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function kyc(Request $request)
    {
        $countries = CountryHelper::getAllCountries();


        return view('pages.kyc', compact('countries'));
    }

    public function verify(Request $request)
    {
        $countries = Country::get()->pluck('id');

        $validation =  $request->validate([
            'name' => 'required|string',
            // 'country' => ['required', Rule::in($countries)],
            'address' => 'required|string',
            'document_type' => 'required|string',
            'document_number' => 'required|string',
            'document' => 'required|image:webp,png,jpg,jpeg,avif|max:2048',
            'photo' => 'required|image:webp,png,jpg,jpeg,avif|max:2048',
        ], [
            'country.in' => 'Please select a valid country',
        ]);

        $document = $request->file('document');
        $photo = $request->file('photo');

        $documentName = time() . fake()->randomNumber(5) . '.' . $document->getClientOriginalExtension();
        $photoName = time() . fake()->randomNumber(5) . '.' . $photo->getClientOriginalExtension();

        $document->move(public_path('storage/kyc'), $documentName);
        $photo->move(public_path('storage/kyc'), $photoName);


        $country = Country::where('name', 'like', '%Tanzania%')->first()->id;

        $user = User::find(auth()->id());

        Mail::to(auth()->user()->email)->queue(new KycSubmission(auth()->id()));

        if ($user->kyc) {

            $user->kyc()->update([
                'name' => $request->name,
                'country_id' => $country,
                'address' => $validation['address'],
                'document_1' => '/kyc/' . $documentName,
                'document_2' => '/kyc/' . $photoName,
                'verified' => false,
                'rejected' => false,
                'pending' => true,
            ]);
        } else {

            $user->kyc()->create([
                'name' => $request->name,
                'country_id' => $country,
                'address' => $validation['address'],
                'document_1' => '/kyc/' . $documentName,
                'document_2' => '/kyc/' . $photoName,
                'rejected' => false,
                'verified' => false,
                'pending' => true,

            ]);
        }

        return back();
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string'
        ]);


        if ($request->verification_code != session('verify')) {
            return back()->with('status', 'failed');
        }

        User::whereId(auth()->id())->update(['email_verified_at' => now()]);

        return redirect('/');
    }

    public static function ApproveKyc($id)
    {
        Kyc::whereId($id)->update([
            'pending' => false,
            'verified' => true,
            'rejected' => false
        ]);

        $kyc = Kyc::findOrFail($id);

        Mail::to($kyc->user->email)->queue(new KycCompleted($kyc->user_id));
    }

    public function login(Request $request)
    {
    }

    public static function rejectKyc($id)
    {
        Kyc::whereId($id)->update([
            'pending' => false,
            'verified' => false,
            'rejected' => true
        ]);

        $kyc = Kyc::findOrFail($id);

        Mail::to($kyc->user->email)->queue(new KycRejected($kyc->user_id));
    }
}
