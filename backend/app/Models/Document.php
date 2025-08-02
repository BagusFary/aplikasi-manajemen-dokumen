<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;
use App\Models\Category;
use App\Models\Department;

class Document extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'description',
        'metadata',
        'file_path',
        'is_active',
        'category_id',
        'department_id',
        'uploaded_by',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
