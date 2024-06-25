<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'percentage',
        'price',
        'user_id', // Include user_id for mass assignment
    ];

    /**
     * Get the user that owns the product request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the product request's images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
