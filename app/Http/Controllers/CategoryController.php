<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // Thêm category mới
    public function store(Request $request)
    {
        // Xác thực dữ liệu yêu cầu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
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
            $category = Category::create($validatedData);
            return response()->json([
                'status' => 'success',
                'message' => 'Add category successfully',
                'data' => $category
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add category',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Lấy tất cả category
    public function index()
    {
        try {
            $categories = Category::all();
            return response()->json([
                'status' => 'success',
                'message' => 'Get categories successfully',
                'data' => $categories
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get categories',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Xóa category theo ID
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Delete category successfully'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete category',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
