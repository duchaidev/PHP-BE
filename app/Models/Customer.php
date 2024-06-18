<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers'; // Tên bảng
    protected $primaryKey = 'id'; // Khóa chính

    protected $fillable = [
        'fullName', 'email', 'phoneNumber', 'address', 'dateOfBirth', 'gender', 'nationality'
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
}
