<?php
/**
 * Created by PhpStorm.
 * User: zhulinjie
 * Date: 23/03/2018
 * Time: 1:29 PM
 */

/**
 * 打印调试
 *
 * @param $content
 * @author zhulinjie
 */
function h_console_log($content)
{
    echo '<pre>';
    print_r($content);
    exit;
}

/**
 * where条件转换
 *
 * @param array $param
 * @return array
 * @author renqingbin
 */
function h_param_where(array $param)
{
    $where = [];
    foreach ($param as $key => $value) {
        if ($value) {
            $where[] = [$key, '=', $value];
        }
    }
    return $where;
}

/**
 * whereIn和whereNotIn条件转换
 *
 * @param array $param
 * @return array
 * @author renqingbin
 */
function h_param_whereIn(array $param)
{
    $where = [];
    foreach ($param as $key => $value) {
        if ($value) {
            $where[$key] = $value;
        }
    }
    return $where;
}

/**
 * 大于小于和大于等于和小于等于的条件转换
 *
 * @param array $param
 * @return array
 * @author renqingbin
 */
function h_param_Interval(array $param)
{
    $where = [];
    // 大于的条件
    if (isset($param['greaterThan']) && $param['greaterThan']) {
        foreach ($param['greaterThan'] as $key => $value) {
            if ($value) {
                $where[] = [$key, '>', $value];
            }
        }
    }
    // 小于的条件
    if (isset($param['lessThan']) && $param['lessThan']) {
        foreach ($param['lessThan'] as $key => $value) {
            if ($value) {
                $where[] = [$key, '<', $value];
            }
        }
    }
    // 大于等于的条件
    if (isset($param['greaterThanEqual']) && $param['greaterThanEqual']) {
        foreach ($param['greaterThanEqual'] as $key => $value) {
            if ($value) {
                $where[] = [$key, '>=', $value];
            }
        }
    }
    // 小于等于的条件
    if (isset($param['lessThanEqual']) && $param['lessThanEqual']) {
        foreach ($param['lessThanEqual'] as $key => $value) {
            if ($value) {
                $where[] = [$key, '<=', $value];
            }
        }
    }

    return $where;
}

/**
 * 排序条件转换
 *
 * @param array $param
 * @return array
 * @author renqingbin
 */
function h_param_orderBy(array $param)
{
    $where = [];
    foreach ($param as $key => $value) {
        if ($value) {
            $where[$key] = $value;
        }
    }
    return $where;
}

/**
 * 高级的参数转化成where条件
 *
 * @param array $param
 * @return mixed
 * @author renqingbin
 */
function h_param_advanced_convert(array $param)
{
    $where = [];
    // 如果有where存在就调用where的转换方法
    if (isset($param['where']) && $param['where']) {
        $whereResult = h_param_where($param['where']);
        if ($whereResult) {
            $where['where'] = $whereResult;
        }
    }

    // 如果有whereIn存在就调用whereIn的转换方法
    if (isset($param['whereIn']) && $param['whereIn']) {
        $whereInReulst = h_param_whereIn($param['whereIn']);
        if ($whereInReulst) {
            $where['whereIn'] = $whereInReulst;
        }
    }

    // 如果有whereNotIn存在就调用whereNotIn的转换方法
    if (isset($param['whereNotIn']) && $param['whereNotIn']) {
        $whereNotInReulst = h_param_whereIn($param['whereNotIn']);
        if ($whereNotInReulst) {
            $where['whereNotIn'] = $whereNotInReulst;
        }
    }

    // 大于小于和大于等于和小于等于的条件封装
    if (isset($param['interval']) && $param['interval']) {
        $interval = h_param_Interval($param['interval']);
        // 判断是否为空
        if ($interval) {
            if (isset($where['where'])) {
                $where['where'] = array_merge($where['where'], $interval);
            } else {
                $where['where'] = $interval;
            }
        }
    }

    // 排序
    if (isset($param['orderBy']) && $param['orderBy']) {
        $orderByReulst = h_param_orderBy($param['orderBy']);
        if ($orderByReulst) {
            $where['orderBy'] = $orderByReulst;
        }
    }

    // 查询字段
    if (isset($param['columns']) && $param['columns']) {
        $where['columns'] = $param['columns'];
    }

    return $where;
}

/**
 * 时间戳格式化
 *
 * @param $time
 * @return string
 * @author zhulinjie
 */
function h_time_format($time)
{
    $format = '';

    // 天
    $day = floor($time / 86400);
    if ($day) {
        $format = $day < 10 ? '0' . $day . '天' : $day . '天';
    }

    // 小时
    $hour = floor(($time % 86400) / 3600);
    if ($hour) {
        $format .= $hour < 10 ? '0' . $hour . '小时' : $hour . '小时';
    }

    // 分钟
    $minute = floor(($time % 86400 % 3600) / 60);
    if ($minute) {
        $format .= $minute < 10 ? '0' . $minute . '分钟' : $minute . '分钟';
    }

    // 秒
    $second = $time % 86400 % 3600 % 60;
    if ($second) {
        $format .= $second < 10 ? '0' . $second . '秒' : $second . '秒';
    }

    return !$format ? '0秒' : $format;
}

/**
 * 参数required验证
 *
 * @param array $param
 * @param array $fields
 * @return array
 */
function h_validate_required(array $param, array $fields)
{
    foreach ($fields as $field) {
        if (!isset($param[$field])) {
            return ['status' => false, 'info' => '缺少' . $field . '参数'];
        }
    }
    return ['status' => true, 'info' => 'success'];
}

/**
 * h_validate_contain
 *
 * @param array $param
 * @param array $fields
 * @return bool
 */
function h_validate_contain(array $param, array $fields)
{
    foreach ($param as $key => $val) {
        if (in_array($key, $fields)) {
            return true;
        }
    }
    return false;
}

/**
 * h_success
 *
 * @param array $param
 * @param bool $isLog
 * @return mixed
 */
function h_success(array $param = [], $isLog = false)
{
    return h_return($param, 'success', $isLog);
}

/**
 * h_error
 *
 * @param array $param
 * @param bool $isLog
 * @return array
 */
function h_error(array $param = [], $isLog = true)
{
    return h_return($param, 'error', $isLog);
}

/**
 * h_success_response
 *
 * @param array $param
 * @param bool $isLog
 * @return \Illuminate\Http\JsonResponse
 */
function h_success_response(array $param = [], $isLog = false)
{
    return response()->json(['ServerTime' => time(), 'ServerNo' => 200, 'ResultData' => h_success($param, $isLog)]);
}

/**
 * h_error_response
 *
 * @param array $param
 * @param bool $isLog
 * @return \Illuminate\Http\JsonResponse
 */
function h_error_response(array $param = [], $isLog = true)
{
    return response()->json(['ServerTime' => time(), 'ServerNo' => 400, 'ResultData' => h_error($param, $isLog)]);
}

/**
 * h_return
 *
 * @param array $param
 * @param $type
 * @param bool $isLog
 * @return array
 */
function h_return(array $param = [], $type, $isLog = false)
{
    // 打印日志
    if ($isLog) {
        h_log($param, $type);
    }

    // 错误类型
    $types = [
        'success' => true,
        'error' => false
    ];

    // 固定返回的参数
    $fillable = ['status', 'data', 'code', 'info'];

    foreach ($fillable as $val) {
        if (!isset($param[$val])) {
            if ($val == 'status') {
                $param[$val] = $types[$type];
            } else {
                $param[$val] = '';
            }
        }
    }

    // 不需要返回的参数
    $except = ['title', 'path'];

    // 其它还需要返回的参数
    $data = [];
    foreach ($param as $key => $val) {
        if (!in_array($key, $except)) {
            $data[$key] = $val;
        }
    }

    return $data;
}

/**
 * 打印成功日志
 *
 * @param array $param
 */
function h_success_log(array $param)
{
    h_log($param, 'success');
}

/**
 * 打印失败日志
 *
 * @param array $param
 */
function h_error_log(array $param)
{
    h_log($param, 'error');
}

/**
 * 打印info日志
 *
 * @param array $param
 */
function h_info_log(array $param)
{
    h_log($param, 'info');
}

/**
 * 记录日志
 *
 * @param array $param
 * @param $type
 */
function h_log(array $param, $type)
{
    $path = !empty($param['path']) ? ': ' . $param['path'] : '';
    $desc = !empty($param['desc']) ? '(' . $param['desc'] . ')' : '';
    $info = $param['info'] . $desc . $path;
    app('log')->info('[' . $type . '] ' . $param['title'] . '[' . Request::path() . ']: ' . $info);
}