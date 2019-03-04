<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExtendModel;

class IndexUsersLogin extends Model
{
    /**
     * 引用model基类
     */
    use ExtendModel;

    /**
     * 定义表名
     * @var string
     */
    protected $table = 'index_users_login';

    /**
     * 可填充字段
     * @var array
     */
    protected $guarded = [];

    /**
     * 主键
     */
    public $primaryKey = 'user_id';

    /**
     * 非int类型主键
     */
    public $incrementing = false;
}
