<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_process(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required'],
            'email'     => ['required', 'email', 'unique:users'],
            'password'  => ['required','confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ]
        ]);

        try {
            $response = $this->authService->register($validated);
            if (!$response) {
                return redirect()->back()->with('error', __('messages.register_failed'));
            }

            return redirect()->route('login')->with('success', __('messages.register_success'));
        } catch (\Throwable $th) {
            Log::error('Error during registration: ' . $th->getMessage(), [
                'line'      => $th->getLine(),
                'file'      => $th->getFile(),
                'message'   => $th->getMessage()
            ]);

            return redirect()->back()->with('error', __('messages.generic_error'));
        }
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'     => ['required', 'email', 'exists:users'],
            'password'  => ['required']
        ],[
            'email.required' => __('messages.email_required'),
            'email.email'    => __('messages.email_invalid'),
            'email.exists'   => __('messages.email_not_registered'),
            'password.required' => __('messages.password_required')
        ]);

        try {
            $response = $this->authService->login($validated);

            if (!$response) {
                return redirect()->back()->with('error', __('messages.invalid_credentials'));
            }
            // Perbaikan: redirect ke halaman movies menggunakan route name
            return redirect()->route('movies')->with('success', __('messages.login_success'));
        } catch (\Throwable $th) {
            Log::error('Error during login: ' . $th->getMessage(), [
                'line'      => $th->getLine(),
                'file'      => $th->getFile(),
                'message'   => $th->getMessage(),
            ]);

            return redirect()->back()->with('error', __('messages.generic_error'));
        }
    }

    public function logout()
    {
        try {
            session()->flush();
            return redirect()->route('login')->with('success', __('messages.logout_success'));
        } catch (\Throwable $th) {
            Log::error('Error during logout: ' . $th->getMessage(), [
                'line'      => $th->getLine(),
                'file'      => $th->getFile(),
                'message'   => $th->getMessage(),
            ]);

            return redirect()->back()->with('error', __('messages.generic_error'));
        }
    }
}
