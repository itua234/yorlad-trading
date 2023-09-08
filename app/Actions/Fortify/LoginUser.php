<?php

namespace App\Actions\Fortify;

use App\Models\{User, Role};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;

class LoginUser implements Authenticatable
{
    protected $guard;

    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function authenticate(array $input): User
    {
        $user = $this->guard->user();
        $role = Role::find($request->role_id);

        if(!$user || !Hash::check($request->password, $user->password)):
            $request->session()->flash('status', 'Your credentials do not match our record');
            elseif(!$user->hasRole($role->name)):
                $request->session()->flash('status', 'You are not permitted');
            else:
                return $user;
        endif;
    }
}
