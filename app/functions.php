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