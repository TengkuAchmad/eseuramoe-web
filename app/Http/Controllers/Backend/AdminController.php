<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $dataUser = $request->session()->get('user');
        $token = $request->session()->get('token');
    
        if (request()->ajax()) {
            $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/get/admin/all';
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($apiUrl);
            
            if ($response->successful()) {
                $users = $response->json()['data'];
                return DataTables::of($users)
                    ->addIndexColumn()
                    ->addColumn('action', function ($item) {
                        $userSession = session()->get('user');
                        $buttonUpdatePassword = '';
                        
                        if ($userSession['role'] === 'SUPERADMIN') {
                            $buttonUpdatePassword = '
                                <div class="d-grid">
                                    <button type="button" class="btn btn-default" id="btn_update_password"
                                        data-bs-toggle="modal" data-bs-target="#updatePasswordModal"
                                        data-uuid="'.$item['UUID_UD'].'">
                                        <i class="fa fa-key"></i> Update Password
                                    </button>
                                </div>';
                        }                        
                        
                        return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle mr-1 mb-1" type="button" data-bs-toggle="dropdown" style="padding: 0.1rem 0.4rem;">
                                    <i class="fa fa-ellipsis-v" style="font-size: 1rem;"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-default" id="btn_edit"
                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-uuid="'.$item['UUID_UD'].'"
                                            data-name="'.$item['Name_UD'].'"
                                            data-email="'.$item['Email_UD'].'">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                    </div>
                                    '.$buttonUpdatePassword.'
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-default btnDelete"
                                            data-uuid="'.$item['UUID_UD'].'">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    })                                  
                    ->editColumn('PhotoUrl_UD', function($item) {
                        $photoUrl = $item['PhotoUrl_UD'] === 'default' ? asset('storage/images/default-users.png') : $item['PhotoUrl_UD'];
                        return '<img src="'.$photoUrl.'" style="max-height: 50px; border-radius: 50%;">';
                    })
                    ->editColumn('LoggedAt_UD', function($item) {
                        return $item['LoggedAt_UD'] ? date('d-m-Y H:i:s', strtotime($item['LoggedAt_UD'])) : '-';
                    })
                    ->editColumn('UpdatedAt_UD', function($item) {
                        return $item['UpdatedAt_UD'] ? date('d-m-Y H:i:s', strtotime($item['UpdatedAt_UD'])) : '-';
                    })
                    ->rawColumns(['action', 'PhotoUrl_UD'])
                    ->make(true);
            }
        }

        $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/get/admin/all';
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($apiUrl);
        $cekAdmin = $response->json()['data'];
    
        return view('dashboard.admin.index', compact('dataUser','cekAdmin'));
    }

    public function create(Request $request)
    {
        $data = $request->all();

        if (empty($data['password'])) {
            $data['password'] = 'password';
        }

        $token = $request->session()->get('token');
        $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/register/admin';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post($apiUrl, $data);

            if ($response->successful()) {
                Log::info('Admin created', [
                    'user_email' => $data['email']
                ]);
                return redirect()->route('admin.index')->with('message', 'User created successfully');
            }

            Log::error('Failed to create admin', [
                'error' => $response->json(),
                'status' => $response->status()
            ]);
            return redirect()->route('admin.index')->with('error', 'Failed to create user');
        } catch (\Exception $e) {
            Log::error('Admin creation exception', [
                'message' => $e->getMessage()
            ]);
            return redirect()->route('admin.index')->with('error', 'System error occurred');
        }
    }

    public function update(Request $request, $uuid)
    {
        $data = $request->only(['name']);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        } else {
            $data['image'] = 'images/default-users.png';
        }

        $token = $request->session()->get('token');
        $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/update/' . $uuid;
        $imagePath = public_path('storage/' . $data['image']);
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->attach('image', fopen($imagePath, 'r'), 'image')
            ->put($apiUrl, [
                'name' => $data['name'],
                'image' => $data['image'],
            ]);

            if ($response->successful()) {
                Log::info('User updated', [
                    'uuid' => $uuid
                ]);
                return redirect()->route('admin.index')->with('message', 'User updated successfully');
            }

            Log::error('Failed to update user', [
                'error' => $response->json(),
                'status' => $response->status(),
                'uuid' => $uuid
            ]);
            return redirect()->route('admin.index')->with('error', 'Failed to update user');
        } catch (\Exception $e) {
            Log::error('User update exception', [
                'message' => $e->getMessage(),
                'uuid' => $uuid
            ]);
            return redirect()->route('admin.index')->with('error', 'System error occurred');
        }
    }

    public function updatePassword(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|same:password_confirmation'
        ], [
            'password.min' => 'Password must be at least 6 characters',
            'password.same' => 'Password confirmation does not match',
            'password.required' => 'Password field is required'
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('admin.index')->with('error', $validator->errors()->first());
        }        

        $token = $request->session()->get('token');
        $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/update/pass/' . $uuid;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->put($apiUrl, [
                'password' => $request->password
            ]);

            if ($response->successful()) {
                cache()->forever('password_updated_' . $uuid, true);
                return redirect()->route('admin.index')->with('message', 'Password updated successfully');
            }

            return redirect()->route('admin.index')->with('error', 'Failed to update password: ' . $response->json()['message']);

        } catch (\Exception $e) {
            Log::error('Password update exception', [
                'message' => $e->getMessage(),
                'uuid' => $uuid
            ]);
            return redirect()->route('admin.index')->with('error', 'System error occurred');
        }
    }

    public function destroy($uuid)
    {
        $token = request()->session()->get('token');
        $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/delete/admin/' . $uuid;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->delete($apiUrl);

        if ($response->successful()) {
            return response()->json(['message' => 'User deleted successfully.']);
        } else {
            return response()->json(['message' => 'Failed to delete user.'], 400);
        }
    }

    public function deleteAll()
    {
        $token = request()->session()->get('token');
        $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . 'delete/admin/all';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->delete($apiUrl);

        if ($response->successful()) {
            return response()->json(['message' => 'All users deleted successfully.']);
        } else {
            return response()->json(['message' => 'Failed to delete all users.'], 400);
        }
    }
}
