<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Captcha;
use App\Models\User;
use App\Models\Magician;
use App\Models\Wallet;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        function customCaptcha()
        {
            $key_gen = "";
            for($i=0; $i < 7; $i++) {   $key_gen .= range('a', 'z')[mt_rand(0, count(range('a', 'z')) - 1)]; }
            return $key_gen;
        }
        $captcha = customCaptcha();
        Session()->put('captcha', $captcha);
        return view('auth.register_page');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'captcha' => 'required'
        ]);

        if(Session()->has('captcha'))
        {
            if(Session()->get('captcha') == $request->captcha)
            {
                // generate random words
                function word_generator()
                {
                    $key_gen = "";
                    for($i=0; $i < 96; $i++) {
                        if ($i % 4 == 0){
                        $key_gen.=" ";
                        }
                        $key_gen .= range('a', 'z')[mt_rand(0, count(range('a', 'z')) - 1)];
                    }
                    return $key_gen;
                }
                Session()->forget('captcha');
                $user = User::create([
                    'name' => $request->username,
                    'username' => $request->username,
                    'mnemonic' => Magician::ed(word_generator()),
                    // 'mnemonic' => word_generator(),
                    'password' => Hash::make($request->password),
                    'last_login' => Carbon::now()->toDateTimeString()
                ]);

                // wallet
                Wallet::create(['user_id' => $user->id]);

                event(new Registered($user));

                Auth::login($user);
                $u_id = Magician::ed($user->id);

                return redirect('your-mnemonic-code');
            }else{
                return redirect()->back()->with('error', 'Invalid captcha');
            }
        }
    }
}
