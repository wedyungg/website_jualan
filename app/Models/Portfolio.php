// app/Models/Portfolio.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'image_path',
        'description',
        'is_featured',
        'order'
    ];

    protected $casts = [
        'is_featured' => 'boolean'
    ];
}