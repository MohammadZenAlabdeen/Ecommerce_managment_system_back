<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'percentage',
        'price',
    ];
    public function deals(){
        return $this->hasMany(Deal::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
