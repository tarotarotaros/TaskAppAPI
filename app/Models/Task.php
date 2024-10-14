<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory; // 追加

    // テーブル名
    protected $table = 'tb_task';

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
        'assignee',
        'created_by',
        'updated_by',
        'update_count'
    ];
}
