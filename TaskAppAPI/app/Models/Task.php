<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // テーブル名
    protected $table = 'tb_task_table';

    // プライマリキーのカラム名
    protected $primaryKey = 'task_id';

    // Laravelの自動タイムスタンプ機能を有効化
    public $timestamps = true;

    // マスアサインメントを許可するフィールド
    protected $fillable = [
        'task_name',
        'content',
        'priority',
        'deadline',
        'start',
        'end',
        'project',
        'status',
        'miled',
        'milestone',
        'manager',
        'created_by',
        'updated_by',
        'update_count'
    ];
}
