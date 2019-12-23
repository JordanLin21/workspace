<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $data = $this->handlerApiException($exception);

        if ($request->is('v1') || $request->is('newlydo')) {
            return response()->json($data['msg'], $data['code']);
        }

        return parent::render($request, $exception);
    }

    private function handlerApiException(Exception $e)
    {
        $return = ['code' => 500, 'msg' => $e->getMessage()];
        switch (true) {
            case $e instanceof MethodNotAllowedHttpException:
                $return['code'] = 405;
                $return['msg'] = 'MethodNotAllowed';
                break;
            case $e instanceof NotFoundHttpException:
                $return['code'] = 404;
                $return['msg'] = 'NotFound';
                break;
            case $e instanceof ValidationException:
                $return['code'] = 422;
                $return['msg'] = $e->errors();
                break;
            case $e instanceof QueryException:
                $return['code'] = 409;
                $return['msg'] = '系统异常';
                break;
            case $e instanceof AuthorizationException:
                $return['code'] = 401;
                $return['msg'] = 'Authorization';
                break;
        }
        return $return;
    }
}
