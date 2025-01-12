<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/auth';
            $response = Http::post($apiUrl, [
                'email' => $request->email,
                'password' => $request->password,
            ]);
        
            $apiData = $response->json();
        
            if ($response->successful()) {
                $apiData = $response->json();
                
                if ($apiData['data']['user']['role'] === 'USER') {
                    return redirect()->back()->with('error', 'Access denied');
                }
            
                $request->session()->put([
                    'user' => [
                        'id' => $apiData['data']['user']['id'],
                        'name' => $apiData['data']['user']['name'],
                        'email' => $apiData['data']['user']['email'],
                        'role' => $apiData['data']['user']['role'],
                        'photo' => $apiData['data']['user']['photo'],
                    ],
                    'token' => $apiData['data']['token']
                ]);
            
                $request->session()->flash('message', 'Login Success');
                return redirect()->route('dashboard');
            }            

            Log::error('Login failed', [
                'error' => $apiData,
                'status' => $response->status(),
                'email' => $request->email
            ]);

            return redirect()->route('login')
                ->withInput($request->only('email'))
                ->with('error', 'Login gagal. Silakan coba lagi.');

        } catch (\Exception $e) {
            Log::error('Login exception', [
                'message' => $e->getMessage(),
                'email' => $request->email
            ]);

            return redirect()->route('login')
                ->withInput($request->only('email'))
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')->with('message', 'Berhasil logout');
    }
}
