<?php

namespace App\Http\Controllers;

use App\Services\Music\MusicContract;
use App\Services\Response\ResponseContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class MusicController
{
    /**
     * @var MusicContract
     */
    protected $service;

    /**
     * @var ResponseContract
     */
    protected $response;

    /**
     * MusicController constructor.
     * @param MusicContract $service
     * @param ResponseContract $response
     */
    public function __construct(MusicContract $service, ResponseContract $response)
    {
        $this->service = $service;
        $this->response = $response;
    }

    /**
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        return response()->json(
            $this->response->add('response',
                $this->service->all(request()->get('skip'), request()->get('take')))->response(), 200
        );
    }

    /**
     * @return JsonResponse
     */
    public function forShinda(): JsonResponse
    {
        return response()->json(
            $this->response->add('response',
                $this->service->forShinda(request()->get('skip'), request()->get('take')))->response(), 200
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function byId(int $id): JsonResponse
    {
        $music = $this->service->getMusic($id);

        if (is_array($music)) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Incorrect id of music')->response(
                    'music.incorrect_id'
                ), 406
            );
        }

        return response()->json(
            $this->response->add('response', $music)->response(), 200
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function groupById(int $id): JsonResponse
    {
        $group = $this->service->getGroup($id);

        if (is_array($group)) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Incorrect id of group')->response(
                    'group.incorrect_id'
                ), 406
            );
        }

        return response()->json(
            $this->response->add('response', $group)->response(), 200
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function musicById(int $id): JsonResponse
    {
        $music = $this->service->getMusicByGroup($id);

        if (is_array($music)) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Incorrect id of group')->response(
                    'group.incorrect_id'
                ), 406
            );
        }

        return response()->json(
            $this->response->add('response', $music)->response(), 200
        );
    }
}