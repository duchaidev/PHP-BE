<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts'; // Tên bảng
    protected $primaryKey = 'id'; // Khóa chính

    protected $fillable = [
        'fullName', 'address', 'numberPhone', 'email', 'message', 'status'
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
}
