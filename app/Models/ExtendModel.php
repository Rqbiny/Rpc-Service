<?php
/**
 * Created by PhpStorm.
 * Demand: renqingbin
 * Date: 21/03/2018
 * Time: 3:29 PM
 */

namespace App\Models;

trait ExtendModel
{
    /**
     * 参数配置
     *
     * @param array $options
     * @return \stdClass
     * @author renqingbin
     */
    private function paramConfig(array $options)
    {
        $std = new \stdClass();
        if (!isset($options['page'])) {
            $options['page'] = 1;
        }
        if (!isset($options['perPage'])) {
            $options['perPage'] = 10;
        }
        if (!isset($options['where'])) {
            $options['where'] = [];
        }
        if (!isset($options['orWhere'])) {
            $options['orWhere'] = [];
        }
        if (!isset($options['columns'])) {
            $options['columns'] = ['*'];
        }
        foreach ($options as $column => $option) {
            $std->$column = $option;
        }
        return $std;
    }

    /**
     * 新增记录
     *
     * @param array $param
     * @return mixed
     * @author renqingbin
     */
    public function einsert(array $param)
    {
        return $this->insert($param);
    }

    /**
     * 新增一条记录并获取ID
     *
     * @param array $param
     * @return mixed
     * @author renqingbin
     */
    public function einsertGetId(array $param)
    {
        return $this->insertGetId($param);
    }

    /**
     * 获取多条数据
     *
     * @param array $options
     * @return mixed
     * @author renqingbin
     */
    public function eselect(array $options = [])
    {
        $options = $this->paramConfig($options);
        $model = $this->where($options->where)->orWhere($options->orWhere);
        $model = $this->addBinding($model, $options, ['leftJoin', 'whereIn', 'whereNotIn', 'orderBy']);
        return $model->get($options->columns);
    }

    /**
     * 获取多条数据（带分页）
     *
     * @param array $options
     * @return mixed
     * @author renqingbin
     */
    public function epaginate(array $options = [])
    {
        $options = $this->paramConfig($options);
        $model = $this->where($options->where)->orWhere($options->orWhere);
        $model = $this->addBinding($model, $options, ['leftJoin', 'whereIn', 'whereNotIn', 'orderBy']);

        if (!empty($options->offset)) {
            $model = $model->offset($options->offset)->limit($options->perPage);
        } else {
            $model = $model->forPage($options->page, $options->perPage);
        }

        return $model->get($options->columns);
    }

    /**
     * 统计记录数
     *
     * @param array $options
     * @return mixed
     * @author renqingbin
     */
    public function ecount(array $options = [])
    {
        $options = $this->paramConfig($options);
        $model = $this->where($options->where)->orWhere($options->orWhere);
        $model = $this->addBinding($model, $options, ['leftJoin', 'whereIn', 'whereNotIn']);
        return $model->count();
    }

    /**
     * 聚合计算相加的总数
     *
     * @param array $options
     * @return mixed
     * @author renqingbin
     */
    public function esum(array $options = [])
    {
        $options = $this->paramConfig($options);
        $model = $this->where($options->where)->orWhere($options->orWhere);
        $model = $this->addBinding($model, $options, ['leftJoin', 'whereIn', 'whereNotIn']);
        return $model->sum($options->value);
    }

    /**
     * 获取一条记录
     *
     * @param array $options
     * @return mixed
     * @author renqingbin
     */
    public function efirst(array $options = [])
    {
        $options = $this->paramConfig($options);
        $model = $this->where($options->where)->orWhere($options->orWhere);
        $model = $this->addBinding($model, $options, ['leftJoin', 'whereIn', 'whereNotIn', 'orderBy']);
        return $model->first($options->columns);
    }

    /**
     * 获取单个值
     *
     * @param array $options
     * @return mixed
     * @author renqingbin
     */
    public function evalue(array $options = [])
    {
        $options = $this->paramConfig($options);
        $model = $this->where($options->where)->orWhere($options->orWhere);
        $model = $this->addBinding($model, $options, ['leftJoin', 'whereIn', 'whereNotIn', 'orderBy']);
        return $model->value($options->value);
    }

    /**
     * 更新记录
     *
     * @param array $options
     * @return mixed
     * @author renqingbin
     */
    public function eupdate(array $options = [])
    {
        $options = $this->paramConfig($options);
        $model = $this->where($options->where)->orWhere($options->orWhere);
        $model = $this->addBinding($model, $options, ['whereIn', 'whereNotIn']);
        return $model->update($options->values);
    }

    /**
     * 删除记录
     *
     * @param array $options
     * @return mixed
     * @author renqingbin
     */
    public function edelete(array $options = [])
    {
        $options = $this->paramConfig($options);
        $model = $this->where($options->where)->orWhere($options->orWhere);
        $model = $this->addBinding($model, $options, ['whereIn', 'whereNotIn']);
        return $model->delete();
    }

    /**
     * 获取一列的值，也可以在返回的数组中指定自定义的键值字段
     *
     * @param array $options
     * @return mixed
     * @author renqingbin
     */
    public function epluck(array $options = [])
    {
        $options = $this->paramConfig($options);
        $model = $this->where($options->where)->orWhere($options->orWhere);
        $model = $this->addBinding($model, $options, ['leftJoin', 'whereIn', 'whereNotIn']);
        return isset($options->key) ? $model->pluck(implode('', $options->columns), $options->key) : $model->pluck(implode('', $options->columns));
    }

    /**
     * truncate
     *
     * @return mixed
     * @author renqingbin
     */
    public function etruncate()
    {
        return $this->truncate();
    }

    /**
     * Add a binding to the query.
     *
     * @param $model
     * @param $options
     * @param array $types
     * @return mixed
     * @author renqingbin
     */
    protected function addBinding($model, $options, array $types)
    {
        foreach ($types as $type) {
            if (!empty($options->$type)) {
                $model = $this->$type($model, $options->$type);
            }
        }
        return $model;
    }

    /**
     * leftJoin
     *
     * @param $model
     * @param array $leftJoin
     * @return mixed
     * @author renqingbin
     */
    protected function leftJoin($model, array $leftJoin)
    {
        foreach ($leftJoin as $option) {
            $model = $model->leftJoin($option[0], $option[1], $option[2], $option[3]);
        }
        return $model;
    }

    /**
     * orderBy
     *
     * @param $model
     * @param array $orderBy
     * @return mixed
     * @author renqingbin
     */
    protected function orderBy($model, array $orderBy)
    {
        foreach ($orderBy as $column => $direction) {
            $model = $model->orderBy($column, $direction);
        }
        return $model;
    }

    /**
     * whereIn
     *
     * @param $model
     * @param array $whereIn
     * @return mixed
     * @author renqingbin
     */
    protected function whereIn($model, array $whereIn)
    {
        foreach ($whereIn as $column => $values) {
            $model = $model->whereIn($column, $values);
        }
        return $model;
    }

    /**
     * whereNotIn
     *
     * @param $model
     * @param array $whereNotIn
     * @return mixed
     * @author renqingbin
     */
    protected function whereNotIn($model, array $whereNotIn)
    {
        foreach ($whereNotIn as $column => $values) {
            $model = $model->whereNotIn($column, $values);
        }
        return $model;
    }
}
