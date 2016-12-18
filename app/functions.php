<?php

function g_getDate()
{

}

function g_loadData($method)
{
    return config("data.$method");
}

function g_isDebug()
{
    return env('APP_DEBUG');
}

function g_loadDbConfig($key)
{
    return \App\Models\Config::where('key', $key)->first()->value;
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