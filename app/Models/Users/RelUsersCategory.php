<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExtendModel;

class RelUsersCategory extends Model
{
    /**
     * 引用model基类
     */
    use ExtendModel;

    /**
     * 定义表名
     * @var string
     */
    protected $table = 'rel_users_category';

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
