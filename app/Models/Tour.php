<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $table = 'tours'; // Tên bảng
    protected $primaryKey = 'id'; // Khóa chính

    protected $fillable = [
        'slug', 'category', 'description', 'featured', 'tourHot', 'difficulty',
        'duration', 'hotelAddress', 'hotelName', 'image', 'itinerary', 'maxGroupSize',
        'name', 'price', 'startDates', 'tourConditions', 'vehicleType', 'status'
    ];
    
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
}
