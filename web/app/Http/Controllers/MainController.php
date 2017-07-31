<?php

namespace App\Http\Controllers;

use App\Services\Response\ResponseContract;
use Illuminate\Http\JsonResponse;

class MainController
{
    const VERSION = 1.2;

    /**
     * @var ResponseContract
     */
    protected $response;

    /**
     * MainController constructor.
     * @param ResponseContract $response
     */
    public function __construct(ResponseContract $response)
    {
        $this->response = $response;
    }

    public function version(): JsonResponse
    {
        $files = [
        ];

        return response()->json(
            $this->response->add('response', ['version' => self::VERSION, 'files' => $files])->response(), 200
        );
    }
}