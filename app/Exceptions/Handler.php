<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use DB;
use Exception;
use Illuminate\Database\QueryException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

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
        'password',
        'password_confirmation',
    ];

    function createLog($e) {
        //if (!preg_match('/Router.php/',$e->getTrace()[0]['file'])) {
        if (!preg_match('/pipeline/i', @$e->getTrace()[0]['file'])) {
            $line = @$e->getTrace()[0]['line'];
            $err = "<br/><hr/><ul>\n";
            $err .= "\t<li>date time " . date('Y-M-d H:m', time()) . "</li>\n";
            $err .= "\t<li>Made By: " . session('id') . "</li>\n";
            $err .= "\t<li>error msg: [" . $e->getCode() . '] ' . $e->getMessage() . ' on line ' . $line . ' of file ' . @$e->getTrace()[0]['file'] . "</li>\n";
            $err .= "\t<li>url: " . url()->current() . "</li>\n";
            $err .= "\t<li>Controller route: " . createRoute() . "</li>\n";
            $err .= "\t<li>Error from username: " . session('username') . "</li>\n";
            $err .= "</ul>\n\n";

            $filename = str_replace('-', '_', date('Y-M-d')) . '.html';
            (isset($line) && $line == 546) ? '' : error_log($err, 3, dirname(__FILE__) . "/../../storage/logs/" . $filename);
        }
        // }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function action($action) {
        if (request()->ajax()) {
            return response()->json(['error' => 'Not Found'], 404);
        } else {
            return $action;
        }
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {
        $this->createLog($exception);
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()->back()->with('warning', 'Token has expired, please reload this page');
        }

        if ($exception instanceof ModelNotFoundException or $exception instanceof NotFoundHttpException) {

            return $this->action(response()->view('errors.404', [], 404));
        } else if ($exception instanceof QueryException) {

            $errorCode = $exception->errorInfo[1];

            if ($errorCode == '7') {
                return redirect()->back()->with('error', 'Looks like some data is duplicated or missing in the system, please contact system administrator or call +255655406004 with error code 004');
            } else
                return redirect()->back()->with('error', 'Sorry, we are experiencing difficulty processing your request, please contact system administrator or call +255655406004 with error code 001');
        } else if ($exception instanceof FatalErrorException) {

            return $this->action(redirect()->back()->with('error', "Sorry, we are experiencing difficulty processing your request, please contact system administrator or call +255655406004 with error code 002 "));
        } else if ($exception instanceof \ErrorException) {


            return $this->action(redirect()->back()->with('error', 'Sorry, we are experiencing difficulty processing your request, please contact system administrator or call +255655406004 with error code 003'));
        } else if ($exception instanceof \LogicException) {

            return $this->action(response()->view('errors.fatal', [], 500));
        }
        return parent::render($request, $exception);
    }

}
