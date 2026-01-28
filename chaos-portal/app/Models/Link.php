<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    // This allows the seeder to insert data into these columns
    protected $fillable = ['title', 'url', 'is_trap'];
}