<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Risiko;

class RisikoController extends Controller
{
    // GET DATA
    public function index()
    {
        return Risiko::all();
    }

    // CREATE
    public function store(Request $request)
    {
        $data = Risiko::create($request->all());
        return response()->json($data);
    }

    // DELETE
    public function destroy($id)
    {
        Risiko::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // UPDATE
    public function update(Request $request, $id)
{
    $data = Risiko::findOrFail($id);
    $data->update($request->all());

    return response()->json($data);
}
}