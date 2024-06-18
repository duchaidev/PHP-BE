<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews'; // Tên bảng
    protected $primaryKey = 'id'; // Khóa chính

    protected $fillable = [
        'tourId', 'customerId', 'rating', 'comment'
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }
}
