<?php

namespace App\Http\Controllers;

use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    protected $authService;
    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    //kode view untuk login dan register
     public function register_process(Request $request)
    {
       $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => [ 'required', 
                            'confirmed', 
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
            if ($response) {
                return redirect()->route('login')->with('success', 'Registrasi berhasil');
            } else {
                return redirect()->back()->with('error', 'Registrasi gagal');
            }
        } catch (\Throwable $th) {
            Log::error([
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Registrasi gagal');
        }
    }
}