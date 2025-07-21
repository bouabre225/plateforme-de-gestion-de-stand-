<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stand;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'stand_id',
        'order_details',
        'order_date',
    ];

    protected $casts = [
        'order_details' => 'array',
        'order_date' => 'datetime',
    ];

    public function stand()
    {
        return $this->belongsTo(Stand::class);
    }
} 