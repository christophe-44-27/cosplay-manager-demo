<?php

namespace App\Domains\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\Domains\Core\Models\CategoryFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
}
