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