<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'created_by',
        'updated_by',
    ];

    public function getImageAttribute($value)
    {
        if(!empty($value))
          return 'storage/' . $value;
        return null;
    }
}
