<?php
/**
 * Created by PhpStorm.
 * User: 24147
 * Date: 2019/8/1
 * Time: 14:45
 */

namespace App\Http\Controllers\Traits;


trait Response
{
    /**
     * 错误响应
     * @param string $message
     * @param array $data
     * @param int $status_code
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public static function success($message = 'success', $data = [], $status_code = 200)
    {
        if (request()->wantsJson()) {
            return self::responseJson(0, $message, $data, [], $status_code);
        } else {
            return back()->with(compact('data', 'message'));
        }
    }

    /**
     * 成功响应
     * @param string $message
     * @param int $code
     * @param int $status_code
     * @param array $errors
     * @param array $data
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public static function error(string $message, int $code = 1, $status_code = 400, $errors = [], array $data = [])
    {
        if (request()->wantsJson()) {
            return self::responseJson($code, $message, $data, $errors, $status_code);
        } else {
            return back()->with(compact('error', 'message'));
        }
    }

    protected static function responseJson($code, $message, $data, $errors, $status_code)
    {
        $data = [
            'code'        => $code,
            'message'     => $message,
            'data'        => $data,
            'errors'      => $errors,
            'status_code' => $status_code,
            'time'        => microtime(true) - LARAVEL_START,
        ];
        return response()->json($data, $status_code);
    }
}
