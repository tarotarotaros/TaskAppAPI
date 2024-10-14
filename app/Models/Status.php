<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    // テーブル名を指定
    protected $table = 'tb_status';

    // マスアサインメントを許可するフィールド
    protected $fillable = [
        'name',
        'color',
    ];
}
