<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

class ModelManagementController extends Controller
{
    public function index(Request $request)
    {
        $dataUser = $request->session()->get('user');
        $token = $request->session()->get('token');

        if ($request->ajax()) {
            $apiUrl = env('APP_API') . '/' . env('MODEL_MANAGEMENT') . '/get/all';
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($apiUrl);

            if ($response->successful()) {
                $models = $response->json()['data'];
                return DataTables::of($models)
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
                                        <button type="button" class="btn btn-danger btnDelete" data-id="' . $item['UUID_MD'] . '">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    })
                    ->editColumn('Url_MD', function ($item) {
                        return '<a href="'.$item['Url_MD'].'" target="_blank">Download Model</a>';
                    })
                    ->rawColumns(['action', 'Url_MD'])
                    ->make(true);
            }

            return response()->json(['error' => 'Unable to fetch data'], 500);
        }

        $apiUrl = env('APP_API') . '/' . env('MODEL_MANAGEMENT') . '/get/all';
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($apiUrl);

        $models = $response->json()['data'] ?? [];

        return view('dashboard.model-management.index', compact('dataUser', 'models'));
    }

    public function create(Request $request)
    {
        $token = $request->session()->get('token');
        $apiUrl = env('APP_API') . '/' . env('MODEL_MANAGEMENT') . '/create';

        if ($request->hasFile('files')) {
            $modelPath = public_path('storage/model');
            
            if (!file_exists($modelPath)) {
                mkdir($modelPath, 0777, true);
            }

            $file = $request->file('files');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($modelPath, $filename);
            $filePath = $modelPath . '/' . $filename;

            \Log::info('File Upload Details:', [
                'filename' => $filename,
                'path' => $filePath
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->attach(
                'files',
                file_get_contents($filePath),
                $filename
            )->post($apiUrl, [
                'name' => $request->name
            ]);

            if ($response->successful()) {
                return redirect()->route('model.index')->with('success', 'Model created successfully.');
            }

            \Log::error('API Response Failed:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }

        return redirect()->route('model.index')->with('error', 'Failed to create model.');
    }

    public function delete($id)
    {
        $token = session()->get('token');
        $apiUrl = env('APP_API') . '/' . env('MODEL_MANAGEMENT') . '/delete/' . $id;
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->delete($apiUrl);

        if ($response->successful()) {
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false]);
    }

}
