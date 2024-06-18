<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class TourController extends Controller
{
    // Lấy tất cả các tour
    public function index()
    {
        $tours = Tour::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Get tour successfully',
            'data' => $tours->map(function ($tour) {
            $tour['image'] = base64_encode($tour['image']);
            $tour['description'] = base64_encode($tour['description']);
            return $tour;
        })
        ], Response::HTTP_OK);
    }

    // Tạo một tour mới
    public function store(Request $request)
    {
          $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'image' => 'required|string', // Thêm các điều kiện xác thực cho hình ảnh
        'description' => 'required|string'
    ]);

        // Tạo slug
        $slug = $this->createSlug($validatedData['name']);
        $validatedData['slug'] = $slug;

        // Tạo bản ghi mới
        $tour = Tour::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Create tour successfully',
            'data' => $tour
        ], Response::HTTP_CREATED);
    }

    // Lấy một tour theo id hoặc slug
    public function show($id)
    {
        $tour = Tour::where('id', $id)->orWhere('slug', $id)->firstOrFail();
        $tour['image'] = base64_encode($tour['image']);
            $tour['description'] = base64_encode($tour['description']);

        return response()->json([
            'status' => 'success',
            'message' => 'Get tour successfully',
            'data' => $tour
        ], Response::HTTP_OK);
    }

    // Cập nhật tour
    public function update(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'image' => 'sometimes|required|string',
            'description' => 'sometimes|required|string'
        ]);

        // Cập nhật dữ liệu
        $tour->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Update tour successfully',
            'data' => $tour
        ], Response::HTTP_OK);
    }

    // Xóa tour
    public function destroy($id)
    {
        $tour = Tour::findOrFail($id);
        $tour->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Delete tour successfully'
        ], Response::HTTP_NO_CONTENT);
    }

    // Tạo slug duy nhất
    private function createSlug($title)
    {
        $slug = Str::slug($title, '-');
        $randomString = Str::random(8);
        $fullSlug = "{$randomString}-{$slug}";

        // Kiểm tra xem slug đã tồn tại chưa
        while (Tour::where('slug', $fullSlug)->exists()) {
            $randomString = Str::random(8);
            $fullSlug = "{$slug}-{$randomString}";
        }

        return $fullSlug;
    }
}
