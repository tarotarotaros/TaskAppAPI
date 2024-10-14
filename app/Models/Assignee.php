<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignee extends Model
{
    use HasFactory;

    // テーブル名を指定
    protected $table = 'tb_assignee';

    // マスアサインメントを許可するフィールド
    protected $fillable = [
        'name',
    ];
}
