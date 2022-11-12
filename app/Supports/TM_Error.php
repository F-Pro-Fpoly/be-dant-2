<?php
namespace App\Supports;

use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class TM_Error 
{
    protected $message;
    protected $status_code;

    public function __construct(\Exception $exception)
    {
        $this->handle($exception);
    }

    public function handle(\Exception $exception) {
        $errCode = $exception->getCode();
        $errCode = empty($errCode) ? Response::HTTP_BAD_REQUEST : $errCode;

        $request = Request::capture();
        $param = $request->all();
        $data = [
            'time'    => date("Y-m-d H:i:s", time()),
            'param'   => json_encode($param),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
            'message' => Str::ascii($exception->getMessage()),
            'error'   => $exception->getMessage(),
        ];

        if (env('APP_ENV') == 'testing') {
            $file = explode("\\", $exception->getFile());
            $file = $file[count($file) - 1];
            $file = explode("/", $file);
            $file = $file[count($file) - 1];
            $file = explode(".", $file);
            $file = $file[0];
            $this->message = "$file:{$exception->getLine()}:" . $exception->getMessage();
            $this->status_code = $errCode;
            // return ['message' => "$file:{$exception->getLine()}:" . $exception->getMessage(), 'code' => $errCode];
        } else {
            $this->message = $exception->getMessage();
            $this->status_code = Response::HTTP_BAD_REQUEST;
            // return ['message' => $exception->getMessage(), 'code' => Response::HTTP_BAD_REQUEST];
        }
    } 

    public function getMessage() {
        return $this->message;
    }

    public function getStatusCode() {
        return $this->status_code;
    }
}