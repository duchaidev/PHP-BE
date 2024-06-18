<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings'; // Tên bảng
    protected $primaryKey = 'id'; // Khóa chính

    protected $fillable = [
        'tourId', 'bookingId', 'customerId', 'bookingDate', 'numberOfParticipants',
        'totalPrice', 'dateStart', 'status'
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

     public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tourId');
    }
}
