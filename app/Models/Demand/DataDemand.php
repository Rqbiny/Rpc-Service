<?php

namespace App\Models\Demand;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExtendModel;

class DataDemand extends Model
{
    /**
     * 引用model基类
     */
    use ExtendModel;

    /**
     * 定义表名
     * @var string
     */
    protected $table = 'data_demand';

    /**
     * 可填充字段
     * @var array
     */
    protected $guarded = [];

    /**
     * 主键
     */
    public $primaryKey = 'demand_id';

    /**
     * 非int类型主键
     */
    public $incrementing = false;

    /**
     * 关闭默认 修改时间 与 创建时间 的填充
     */
    public $timestamps = false;

    /**
     * 关联信息权限表
     */
    public function demandPermission()
    {
        return $this->hasOne('App\Models\Demand\DataDemandPermission', 'id', 'demand_id');
    }

    /**
     * 关联信息详情表
     */
    public function demandInfo()
    {
        return $this->hasOne('App\Models\Demand\DataDemandInfo', 'demand_id', 'demand_id');
    }
}
