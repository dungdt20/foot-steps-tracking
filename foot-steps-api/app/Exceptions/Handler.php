<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Infrastructure\Util\ResponseHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseHelper;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse|Response
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        return $this->handleApiException($request, $e);
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse|Response
     * @throws Throwable
     */
    public function handleApiException($request, Throwable $e)
    {
        switch ($e) {
            case $e instanceof ValidationException:
                return $this->sendError(
                    __('validation.param-invalid'),
                    Response::HTTP_BAD_REQUEST,
                    $e->errors()
                );

            case $e instanceof NotFoundHttpException:
                return $this->sendError(
                    __('exception.url_not_found'),
                    Response::HTTP_NOT_FOUND
                );

            case $e instanceof MethodNotAllowedHttpException:
                return $this->sendError(
                    __('exception.method_not_allow'),
                    Response::HTTP_METHOD_NOT_ALLOWED
                );

            default :
                if (env('APP_DEBUG') && env('APP_ENV') === 'local') {
                    return parent::render($request, $e);
                }

                $message = get_class($e) . ' ERROR: ' . $e->getTraceAsString();
                Log::error($message);

                return $this->sendServerError(
                    __('exception.server_error'),
                    $e->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
        }
    }
}
