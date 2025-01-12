<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

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
                                <button class="btn dropdown-toggle mr-1 mb-1" type="button" data-bs-toggle="dropdown" style="padding: 0.1rem 0.4rem;">
                                    <i class="fa fa-ellipsis-v" style="font-size: 1rem;"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-danger btnDelete" data-id="' . $item['UUID_MD'] . '">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    })
                    ->editColumn('Url_MD', function ($item) {
                        return '<a href="'.$item['Url_MD'].'" target="_blank" style="color: #f05c26;" onmouseover="this.style.color=\'#d94d1f\'" onmouseout="this.style.color=\'#f05c26\'">Download Model</a>';
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

        try {
            if ($request->hasFile('files')) {
                $modelPath = public_path('storage/model');
                
                if (!file_exists($modelPath)) {
                    mkdir($modelPath, 0777, true);
                }

                $file = $request->file('files');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move($modelPath, $filename);
                $filePath = $modelPath . '/' . $filename;

                Log::info('File Upload Details', [
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
                    Log::info('Model created successfully', [
                        'name' => $request->name
                    ]);
                    return redirect()->route('model.index')->with('message', 'Model created successfully');
                }

                Log::error('Failed to create model', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return redirect()->route('model.index')->with('error', 'Failed to create model');
            }

            return redirect()->route('model.index')->with('error', 'No file uploaded');
        } catch (\Exception $e) {
            Log::error('Model creation exception', [
                'message' => $e->getMessage()
            ]);
            return redirect()->route('model.index')->with('error', 'System error occurred');
        }
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
