<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApplicationService;
use Exception;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;

class ApplicationController extends Controller
{
    protected $service;

    public function __construct(ApplicationService $service)
    {
        $this->service = $service;
    }

    /**
     * Apply for a job
     */
    public function apply(Request $request, $id)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'experience' => 'required|string',
                'expected_salary' => 'required|numeric',
                'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            ]);

            // Dapatkan user yang sedang login
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }

            // Tambahkan job_id ke data
            $validated['job_id'] = $id;

            // Ambil file CV dari request
            $cvFile = $request->file('cv');

            // Proses apply via service
            $application = $this->service->applyJob($user->id, $validated, $cvFile);

            return response()->json([
                'success' => true,
                'message' => 'Lamaran berhasil dikirim!',
                'data' => $application,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception   $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
