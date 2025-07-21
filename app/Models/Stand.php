<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Order;

class Stand extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_stand',
        'description',
        'utilisateur_id',
    ];

    public function entrepreneur()
    {
        return $this->belongsTo(Entrepreneur::class, 'utilisateur_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
} 