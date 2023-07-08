<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Payment;


class PaymentController extends Controller
{

    public function index()
    {
        $payments = Payment::all();
        return response()->json(['message' => 'payments listed successfully', 'payments' => $payments]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',

            'payment_method' => 'required|string',
            'file_upload' => 'required|file',
            'account_title' => 'required|string|min:3|max:75',
            'account_number' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $path = null;
//        $imageName = null;
        if ($request->hasFile('file_upload')) {
            $image = $request->file('file_upload');
//            $imageName = time().'_'.$image->getClientOriginalName();
            $path = $image->store('payments');
        };

        $payment = Payment::create($request->all());
        $payment->file_upload = '/storage/app/public/' . $path;
//        $payment->file_name = $imageName;
        $payment->save();
        $fileUrl = Storage::url($path);
        return response()->json([
            'message' => ' payment created successfully', 'payment' => $payment, 'download file' => $fileUrl],
            201);

    }

    public function show($booking_id)
    {
        $payment = Payment::where('booking_id', $booking_id)->get();
        return response()->json(['message' => 'payment listed successfully', 'payment' => $payment]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string',

            'booking_id' => 'nullable',
            'payment_method' => 'nullable',
            'file_upload' => 'nullable',
            'account_title' => 'nullable',
            'account_number' => 'nullable',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $payment = Payment::findOrFail($id);
//        $payment = Payment::where('booking_id', $booking_id)->get();
        $payment->update($request->all());

        return response()->json(['message' => 'payment updated successfully', 'payment' => $payment]);
    }

    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();
        return response()->json(['message' => 'payment deleted successfully']);
    }

}

