<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stand;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'image_url',
        'stand_id',
    ];

    public function stand()
    {
        return $this->belongsTo(Stand::class);
    }
}