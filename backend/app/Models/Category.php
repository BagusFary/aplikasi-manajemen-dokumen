<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Category extends Model
{
    protected $fillable = ['name', 'is_active', 'metadata'];

    use HasUuids;
}
