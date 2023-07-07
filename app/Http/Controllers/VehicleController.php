<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return response()->json(['message' => 'vehicles listed successfully', 'vehicles' => $vehicles]);
    }
    public function availableVehicles(Request $request)
    {
        $availableVehicles = Vehicle::whereDoesntHave('booking', function ($query) use ($request) {
            $query->where([
                ['start_date', '<=',$request->start_date],
                ['end_date', '>=', $request->start_date]
            ])->orWhere([
                ['start_date', '<=',$request->end_date],
                ['end_date', '>=', $request->end_date]
            ])->orWhere([
                ['start_date', '>=',$request->start_date],
                ['end_date', '<=', $request->end_date]
            ]);
      })->get();
//        $availableVehicles = Vehicle::whereDoesntHave('booking', function ($query) use ($request) {
//            $query->whereNotBetween('end_date', [$request->end_date, $request->start_date])->whereNotBetween('start_date',[$request->end_date, $request->start_date]);
//      })->get();
        return response()->json(['message' => 'vehicles listed successfully', 'available vehicles' => $availableVehicles]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'model' => 'required|integer',
            'no_plate' => 'required|integer',
            'no_seats' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $vehicle = Vehicle::create($request->all());
        $vehicle->save();
//        $vehicle->booking()->attach($request->booking_id);
//        $vehicle->user()->attach($request->user_id);
        return response()->json([
            'message' => 'vehicle created successfully', 'vehicle' => $vehicle],
            201);
    }

    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return response()->json(['message' => 'vehicle listed successfully', 'vehicle' => $vehicle]);
    }

    public function assignedVehicle(Request $request)
    {
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $vehicle->user()->attach($request->user_id);
        return response()->json(['message' => 'vehicle assiged successfully', 'vehicle' => $vehicle]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'model' => 'required|integer',
            'no_plate' => 'required|integer',
            'no_seats' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->all());
        return response()->json(['message' => 'vehicle updated successfully', 'vehicle' => $vehicle]);
    }

    public function destroy($id)
    {
        Vehicle::findOrFail($id)->delete();
        return response()->json(['message' => 'vehicle deleted successfully']);
    }

}

