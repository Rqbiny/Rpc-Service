<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExtendModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelUsersDemandBrowse extends Model
{
    /**
     * 引用model基类
     */
    use ExtendModel;
    use SoftDeletes;

    /**
     * 定义表名
     * @var string
     */
    protected $table = 'rel_users_demand_browse';

    /**
     * 可填充字段
     * @var array
     */
    protected $guarded = [];

    /**
     * 主键
     */
    public $primaryKey = 'id';

    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * 关联信息表
     */
    public function demand()
    {
        return $this->hasOne('App\Models\Demand\DataDemand', 'demand_id', 'demand_id');
    }
}
