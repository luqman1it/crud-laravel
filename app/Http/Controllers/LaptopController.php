<?php

namespace App\Http\Controllers;

use App\Http\Requests\laptopRequest;
use App\Models\laptop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LaptopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laptop = laptop::all();
        return response()->json([
            'status' => 'success',
            'laptop' => $laptop
        ]);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(laptopRequest $request)
    {

        try {
            DB::beginTransaction();
            $laptop = laptop::create([
                'name' => $request->name,
                'category' => $request->category

            ]);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'laptop' => $laptop
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json([
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(laptop $laptop)
    {
        //
        return response()->json([
            'status' => 'success',
            'laptop' => $laptop
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, laptop $laptop)
    {
        //
        $request->validate([
            'name' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255'
        ]);
        $newData = [];
        if (isset($request->name)) {
            $newData['name'] = $request->name;
        }
        if (isset($request->category)) {
            $newData['category'] = $request->category;
        }
        $laptop->update($newData);
        return response()->json([
            'status' => 'success',
            'laptop' => $laptop
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(laptop $laptop)
    {
        //
        $laptop->delete();
    }
}
