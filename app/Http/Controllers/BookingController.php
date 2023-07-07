<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller

{
    public function index()
    {
        $bookings = Booking::all();
        return response()->json(['message' => 'bookings listed successfully', 'bookings' => $bookings]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'vehicle_id'=> 'required',
            'departure_address' => 'nullable',
            'destination_address' => 'nullable',
            'phone_no' => 'nullable',
            'cnic' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $booking = Booking::create($request->all());
        $booking->save();
        $booking->vehicle()->associate($request->vehicle_id);
        $booking->save();
        $booking->user()->associate($request->user('api'));
        $booking->save();
        return response()->json([
            'message' => 'booking created successfully', 'booking' => $booking],
            201);
    }
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return response()->json(['message' => 'booking listed successfully', 'booking' => $booking]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'vehicle_id'=> 'nullable',
            'departure_address' => 'required|regex:/(^[-0-9A-Za-z.,\/ ]+$)/',
            'destination_address' => 'required|regex:/(^[-0-9A-Za-z.,\/ ]+$)/',
            'phone_no' => 'required|numeric|min:11',
            'cnic' => 'required', 'regex:/^([0-9]{5})[\-]([0-9]{7})[\-]([0-9]{1})+/',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $booking = Booking::findOrFail($id);
        $booking->update($request->all());
        return response()->json(['message' => 'booking updated successfully', 'booking' => $booking]);
    }
    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();
        return response()->json(['message' => 'booking deleted successfully']);
    }
}






