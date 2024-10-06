<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    use HasFactory;
    protected $table = 'tb_project';

    protected $fillable = [
        'name',
        'is_complete',
        'created_by',
        'updated_by',
        'update_count'
    ];
}
