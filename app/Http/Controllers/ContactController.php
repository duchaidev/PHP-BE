<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // Lấy tất cả contact
    public function index()
    {
        try {
            $contacts = Contact::all();
            return response()->json([
                'data' => $contacts,
                'message' => 'Get contacts successfully'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get contacts',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Tạo contact mới
    public function store(Request $request)
    {
        // Xác thực dữ liệu yêu cầu
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string|max:255',
            'message' => 'required|string',
            'address' => 'sometimes|string|max:255',
            'numberPhone' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], Response::HTTP_BAD_REQUEST);
        }

        // Lấy dữ liệu hợp lệ
        $validatedData = $validator->validated();

        // Tạo bản ghi mới
        try {
            $contact = Contact::create([
                'fullName' => $validatedData['fullName'],
                'address' => $validatedData['address'] ?? '',
                'numberPhone' => $validatedData['numberPhone'] ?? '',
                'email' => $validatedData['email'] ?? '',
                'message' => $validatedData['message'],
                'status' => false,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Create contact successfully',
                'data' => $contact
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create contact',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Cập nhật contact
    public function update(Request $request, $id)
    {
        try {
            $contact = Contact::findOrFail($id);

            $validatedData = $request->validate([
                'fullName' => 'sometimes|required|string|max:255',
                'message' => 'sometimes|required|string',
                'address' => 'sometimes|string|max:255',
                'numberPhone' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|max:255',
            ]);

            // Cập nhật dữ liệu
            $contact->update($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Update contact successfully',
                'data' => $contact
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update contact',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
