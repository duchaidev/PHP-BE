<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories'; // Tên bảng
    protected $primaryKey = 'id'; // Khóa chính

    protected $fillable = [
        'name', 'description'
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
}
