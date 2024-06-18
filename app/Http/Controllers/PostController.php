<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    // Tạo slug duy nhất
    private function createSlug($title)
    {
        $slug = Str::slug($title, '-');
        $randomString = Str::random(8);
        $fullSlug = "{$randomString}-{$slug}";

        // Kiểm tra xem slug đã tồn tại chưa
        while (Post::where('slug', $fullSlug)->exists()) {
            $randomString = Str::random(8);
            $fullSlug = "{$slug}-{$randomString}";
        }

        return $fullSlug;
    }

    // Lấy tất cả bài viết
    public function index()
    {
        try {
            $posts = Post::all();

            return response()->json([
            'status' => 'success',
            'message' => 'Get Post successfully',
            'data' => $posts->map(function ($post) {
            $post['image'] = base64_encode($post['image']);
            $post['content'] = base64_encode($post['content']);
            return $post;
        })
        ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get posts',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Lấy bài viết theo ID
    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post['image'] = base64_encode($post['image']);
            $post['content'] = base64_encode($post['content']);
            return response()->json([
                'data' => $post,
                'message' => 'Get post by id successfully'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get post',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    // Cập nhật bài viết
    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);

            $validatedData = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'content' => 'sometimes|required|string',
                'image' => 'sometimes|required|string'
            ]);

            // Cập nhật dữ liệu
            $post->update($validatedData);

            return response()->json([
                'status' => 200,
                'message' => 'Update post successfully',
                'data' => $post
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update post',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    // Tạo bài viết mới
    public function store(Request $request)
    {
        // Xác thực dữ liệu yêu cầu
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], Response::HTTP_BAD_REQUEST);
        }

        // Lấy dữ liệu hợp lệ
        $validatedData = $validator->validated();

        // Tạo slug
        $slug = $this->createSlug($validatedData['title']);
        $validatedData['slug'] = $slug;

        // Tạo bản ghi mới
        try {
            $newPost = Post::create([
                'title' => $validatedData['title'],
                'content' => $validatedData['content'],
                'author' => $request->input('author', 'Anonymous'),
                'category' => $request->input('category', 'Other'),
                'trending' => $request->input('trending', false),
                'image' => $validatedData['image'],
                'slug' => $slug,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Create post successfully',
                'data' => $newPost
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create post',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Xóa bài viết
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Delete post successfully'
            ], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete post',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
