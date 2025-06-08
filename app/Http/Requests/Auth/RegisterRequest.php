<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]*$/'],
            'gender' => ['required', 'in:male,female'],
            'address' => ['required', 'string', 'max:500'],
            'longitude' => ['required', 'string', 'max:500'],
            'latitude' => ['required', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name cannot exceed 255 characters.',

            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'The email cannot exceed 255 characters.',
            'email.unique' => 'This email is already registered.',

            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',

            'phone.required' => 'The phone number field is required.',
            'phone.string' => 'The phone number must be a string.',
            'phone.max' => 'The phone number cannot exceed 20 characters.',
            'phone.regex' => 'Please enter a valid phone number format.',

            'gender.required' => 'The gender field is required.',
            'gender.in' => 'Please select a valid gender option.',

            'address.required' => 'The address field is required.',
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address cannot exceed 500 characters.',

            'longitude.required' => 'The longitude field is required.',
            'longitude.string' => 'The longitude must be a string.',
            'longitude.max' => 'The longitude cannot exceed 500 characters.',

            'latitude.required' => 'The latitude field is required.',
            'latitude.string' => 'The latitude must be a string.',
            'latitude.max' => 'The latitude cannot exceed 500 characters.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        logger()->info($validator->errors());
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }
}
