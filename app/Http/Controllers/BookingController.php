<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Tour;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function createBookingService(Request $request)
    {
        try {
            $customerId = $request->input('customerId');
            $data = $request->all();

            if (!$request->input('customerId')) {
                $customer = Customer::create([
                    'fullName' => $data['fullName'],
                    'email' => $data['email'],
                    'phoneNumber' => $data['phoneNumber'],
                    'address' => $data['address'],
                    'dateOfBirth' => $data['dateOfBirth'] ?? '',
                    'gender' => $data['gender'] ?? '',
                    'nationality' => $data['nationality'] ?? '',
                ]);
                $customerId = $customer->id;
            }

            Booking::create([
                'customerId' => $customerId,
                'tourId' => $data['tourId'],
                'status' => 'PENDING',
                'bookingDate' => now(),
                'numberOfParticipants' => $data['numberOfParticipants'] ?? 1,
                'totalPrice' => $data['totalPrice'],
                'dateStart' => $data['dateStart'],
                'bookingId' => $data['bookingId'],
            ]);

            return response()->json(['status' => 200,'message' => 'Create booking successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getAllBookingService()
    {
        try {
            $bookings = Booking::with(['tour', 'customer'])->get();

            return response()->json(['status' => 200,'data' => $bookings, 'message' => 'Get all bookings successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getBookingByIdService($id)
    {
        try {
            $booking = Booking::with(['tour', 'customer'])->find($id);

            if (!$booking) {
                return response()->json(['error' => 'Booking not found'], 404);
            }

            return response()->json(['status' => 200, 'data' => $booking, 'message' => 'Get booking successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateBookingByIdService(Request $request, $id)
    {
        try {
            $booking = Booking::find($id);

            if (!$booking) {
                return response()->json(['error' => 'Booking not found'], 404);
            }

            $booking->update($request->all());

            return response()->json([
                'status' => 200,
                'booking' => $booking,
                'message' => 'Update booking successfully'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
