<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Models\{User, Role};
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        /*Fortify::registerView(function (){
            return view('auth.register');
        });

        Fortify::loginView(function (){
            return view('auth.login');
        });*/

        /*Fortify::requestPasswordResetLinkView(function (){
            return view('auth.forgot-password');
        });*/

        /*Fortify::resetPasswordView(function ($request){
            return view('auth.reset-password', ['request' => $request]);
        });

        Fortify::confirmPasswordView(function (){
            return view('auth.confirm-password');
        });

        Fortify::twoFactorChallengeView(function (){
            return view('auth.two-factor-challenge');
        });

        Fortify::authenticateUsing(function (Request $request){
            //return new LoginUser($this->guard);
            $user = User::where('email', $request->email)->first();
            $role = Role::find($request->role_id);

            if(!$user || !Hash::check($request->password, $user->password)):
                $request->session()->flash('status', 'Your credentials do not match our record');
                elseif(!$user->hasRole($role->name)):
                    $request->session()->flash('status', 'You are not permitted');
                else:
                    return $user;
            endif;
        });*/

    }
}
