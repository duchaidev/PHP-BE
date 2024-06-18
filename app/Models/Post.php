<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts'; // Tên bảng
    protected $primaryKey = 'id'; // Khóa chính

    protected $fillable = [
        'title', 'content', 'author', 'category', 'trending', 'image', 'slug'
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
}
