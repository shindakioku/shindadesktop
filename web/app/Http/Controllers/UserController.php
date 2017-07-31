<?php

namespace App\Http\Controllers;

use App\Services\Response\ResponseContract;
use App\Services\User\UserContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Entities\User;

class UserController
{
    /**
     * @var UserContract
     */
    protected $service;

    /**
     * @var ResponseContract
     */
    protected $response;

    /**
     * UserController constructor.
     * @param UserContract $service
     * @param ResponseContract $response
     */
    public function __construct(UserContract $service, ResponseContract $response)
    {
        $this->service = $service;
        $this->response = $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function auth(Request $request): JsonResponse
    {
        if (!$request->has(['login', 'password', 'auth'])) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Заполните все поля')->response(
                    'system.validation_error'
                ), 406
            );
        }

        $result = $this->service->auth(
            (string)$request->login, (string)$request->password, (bool)$request->auth
        );

        if (is_array($result)) {
            return response()->json(
                $this->response->changeStatus()->add('response', $result['response'])->response(
                    $result['error_code']
                ), 406
            );
        }

        return response()->json(
            $this->response->add('response', $result)->response(), 200
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addFavorite(Request $request): JsonResponse
    {
        if (!$request->has(['entity', 'token', 'entity_id', 'user_id'])) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Заполните все поля')->response(
                    'system.validation_error'
                ), 406
            );
        }

        if (!User::where('token', $request->token)->first()) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Вы забыли токен')->response(
                    'system.validation_error'
                ), 406
            );
        }

        if ('anime' != $request->entity && 'music' != $request->entity) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Не правильное имя для сущности')->response(
                    'user.favorite.incorrect_entity_name'
                ), 406
            );
        }

        $result = $this->service->addFavorite(
            (string)$request->entity, (int)$request->entity_id, (int)$request->user_id
        );

        if (is_array($result)) {
            return response()->json(
                $this->response->changeStatus()->add('response', $result['response'])->response(
                    $result['error_code']
                ), 406
            );
        }

        return response()->json(
            $this->response->add('response', $result)->response(), 200
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function favoriteAnime(int $id): JsonResponse
    {
        $result = $this->service->getFavorite($id, 'anime');

        if (is_array($result)) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Не корректный айдишник юзера')->response(
                    'user.favorite.incorrect_user_id'
                ), 406
            );
        }

        return response()->json(
            $this->response->add('response', $result)->response(), 200
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function favoriteMusic(int $id): JsonResponse
    {
        $result = $this->service->getFavorite($id, 'music');

        if (false == $result) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Не корректный айдишник юзера')->response(
                    'user.favorite.incorrect_user_id'
                ), 406
            );
        }

        return response()->json(
            $this->response->add('response', $result)->response(), 200
        );
    }

    public function hasFavorite(int $userId, string $entity, int $entityId): JsonResponse
    {
        $result = $this->service->hasFavorite($userId, $entity, $entityId);

        return response()->json(
            $this->response->add('response', $result)->response(), 200
        );
    }
}