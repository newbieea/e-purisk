<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loss;

class LossController extends Controller
{
    // GET DATA
    public function index()
    {
        return response()->json(Loss::latest()->get());
    }

    // STORE DATA
    public function store(Request $request)
    {
        try {
            $data = Loss::create($request->all());
            return response()->json($data);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}