<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;

class PhoneVerified implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $verified_phone_exists = User::where('phone', $value)
        ->whereNotNull('phone_verified_at')->first();
        
        if ($verified_phone_exists) {
            $fail('This :attribute already exist');
        }
    }
}
