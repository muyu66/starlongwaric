<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    public function report(Exception $e)
    {
        parent::report($e);
    }

    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            if (! g_is_debug()) {
                throw new Exception('没有此权限');
            } else {
                $sql_log = last(DB::getQueryLog());

                /**
                 * 替换 SQL 绑定数据
                 */
                $sql = explode("?", $sql_log['query']);
                foreach ($sql_log['bindings'] as $key => $value) {
                    $sql[$key] .= "'$value'";
                }

                $e = new NotFoundHttpException(
                    'Model: ' . $e->getModel() . PHP_EOL .
                    'Erroe: 未找到对应数据' . PHP_EOL .
                    'Sql: ' . implode("", $sql)
                );
            }
        }

        if ($e instanceof CustomException && $request->wantsJson()) {
            return Response::json([
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
            ], $e->getCode());
        }

        return parent::render($request, $e);
    }
}
