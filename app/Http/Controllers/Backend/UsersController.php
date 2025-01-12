<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $dataUser = $request->session()->get('user');
        $token = $request->session()->get('token');
    
        if (request()->ajax()) {
            $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/get/all';
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($apiUrl);
            
            if ($response->successful()) {
                $users = $response->json()['data'];
                return DataTables::of($users)
                    ->addIndexColumn()
                    ->addColumn('action', function ($item) {
                        return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle mr-1 mb-1" type="button" data-bs-toggle="dropdown">
                                    <i class="fa fa-2x fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu bg-secondary">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-default" id="btn_edit"
                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-uuid="'.$item['UUID_UD'].'"
                                            data-name="'.$item['Name_UD'].'"
                                            data-email="'.$item['Email_UD'].'">Edit</button>
                                    </div>
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-default btnDelete"
                                            data-uuid="'.$item['UUID_UD'].'">Delete</button>
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
                    ->rawColumns(['action', 'PhotoUrl_UD'])
                    ->make(true);
            }
        }

        $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/get/all';
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($apiUrl);
        $cekUser = $response->json()['data'];
    
        return view('dashboard.users.index', compact('dataUser','cekUser'));
    }
    
    public function create(Request $request)
    {
        $data = $request->all();
        
        if (empty($data['password'])) {
            $data['password'] = 'password';
        }

        $token = $request->session()->get('token');
        $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/register';
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post($apiUrl, $data);

        if ($response->successful()) {
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'Failed to create user.');
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
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->attach('image', fopen($imagePath, 'r'), 'image')
          ->put($apiUrl, [
              'name' => $data['name'],
              'image' => $data['image'],
          ]);
    
        if ($response->successful()) {
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'Failed to update user.');
        }
    }

    public function destroy($uuid)
    {
        $token = request()->session()->get('token');
        $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/delete/' . $uuid;

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
        $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/delete/all';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->delete($apiUrl);

        if ($response->successful()) {
            return response()->json(['message' => 'All users deleted successfully.']);
        } else {
            return response()->json(['message' => 'Failed to delete all users.'], 400);
        }
    }

    public function createAdmin(Request $request)
    {
        $data = $request->all();
        
        if (empty($data['password'])) {
            $data['password'] = 'password';
        }

        $token = $request->session()->get('token');
        $apiUrl = env('APP_API') . '/' . env('USER_MANAGEMENT') . '/register/admin';
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post($apiUrl, $data);

        if ($response->successful()) {
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } else {
            return redirect()->route('users.index')->with('error', 'Failed to create user.');
        }
    }
}
