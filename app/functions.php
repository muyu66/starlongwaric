<?php

function g_get_star_date()
{
    $base = 1482246351;
    $now = (time() - $base) * 100 + $base;
    $carbon = \Carbon\Carbon::createFromTimestamp($now);
    return $carbon->addYears(88)->toDateTimeString();
}

function g_load_import($name, $method)
{
    $path = base_path('import/' . $name . '.php');
    if (file_exists($path)) {
        $array = require($path);
        return $array[$method];
    } else {
        throw new Exception('can not load config');
    }
}

function g_is_debug()
{
    return env('APP_DEBUG');
}

/**
 * @description 数组生成器
 * @param $count
 * @return array|Generator
 * @author Zhou Yu
 */
function g_yields($count)
{
    // 数据小于 30000 时, range 性能最佳, 消耗最低
    if ($count <= 30000) {
        return range(0, $count - 1);
    }
    return g_get_generator($count);
}

function g_get_generator($count)
{
    for ($i = 0; $i <= $count; $i++) {
        yield $i;
    }
}

/**
 * 如果原数组存在这个KEY，则更新它，否则添加
 *
 * @param $arrays '仅针对一维数组'
 * @param $key
 * @param $value
 * @return array
 * @author Zhou Yu
 */
function g_add_or_update($arrays, $key, $value)
{
    if (! $arrays) {
        $arrays = [$key => $value];
    } else {
        foreach ($arrays as $k => $v) {
            $arrays[$k] = $value;
        }
    }
    return $arrays;
}

function g_array_add($arrays, $value)
{
    if (! $arrays) {
        $arrays = [$value];
    } else {
        if (! in_array($value, $arrays)) {
            $arrays[] = $value;
        }
    }
    return $arrays;
}

function g_array_del($arrays, $value)
{
    $key = array_search($value, $arrays);
    if ($key !== false) {
        unset($arrays[$key]);
        return array_values($arrays);
    }
    return $arrays;
}

/**
 * 将时间转换成时间短句
 * 比如，11分钟 2小时 3天
 *
 * @param $timestamp
 * @return array
 */
function g_get_online_status($timestamp)
{
    list($day, $hour, $min) = explode('::', gmstrftime("%j::%H::%M", $timestamp));

    if ($day != '001') {
        if ((int)$day > 30) {
            return ['is_online' => 0, 'time' => '超过1个月'];
        }
        return ['is_online' => 0, 'time' => (int)$day - 1 . '天'];
    } else {
        if ($hour != '00') {
            return ['is_online' => 0, 'time' => (int)$hour . '小时'];
        } else {
            if ($min != '00') {
                if ((int)$min >= 5) {
                    return ['is_online' => 0, 'time' => (int)$min . '分钟'];
                }
            }
            return ['is_online' => 1, 'time' => '0'];
        }
    }
}
