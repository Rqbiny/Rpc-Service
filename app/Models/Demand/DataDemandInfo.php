<?php

namespace App\Models\Demand;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExtendModel;

class DataDemandInfo extends Model
{
    /**
     * 引用model基类
     */
    use ExtendModel;

    /**
     * 定义表名
     * @var string
     */
    protected $table = 'data_demand_info';

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
}
