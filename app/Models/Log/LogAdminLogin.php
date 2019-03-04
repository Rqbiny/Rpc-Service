<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExtendModel;

class LogAdminLogin extends Model
{
    /**
     * 引用model基类
     */
    use ExtendModel;

    /**
     * 定义表名
     * @var string
     */
    protected $table = 'log_admin_login';

    /**
     * 可填充字段
     * @var array
     */
    protected $guarded = [];

    /**
     * 主键
     */
    public $primaryKey = 'id';
}
