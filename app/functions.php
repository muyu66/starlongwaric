<?php

function g_getDate()
{
    $base = 1482246351;
    $now = (time() - $base) * 100 + $base;
    $carbon = \Carbon\Carbon::createFromTimestamp($now);
    return $carbon->addYears(88);
}

function g_load_import($name, $method)
{
    return config("import_$name.$method");
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