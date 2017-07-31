<?php

namespace App\Http\Controllers;

use App\Services\Anime\AnimeContract;
use App\Services\Response\ResponseContract;
use Illuminate\Http\JsonResponse;

class AnimeController
{
    /**
     * @var AnimeContract
     */
    protected $service;

    /**
     * @var ResponseContract
     */
    protected $response;

    /**
     * AnimeController constructor.
     * @param AnimeContract $service
     * @param ResponseContract $response
     */
    public function __construct(AnimeContract $service, ResponseContract $response)
    {
        $this->service = $service;
        $this->response = $response;
    }

    /**
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        $response = [];
        $anime = $this->service->all(request()->get('skip'), request()->get('take'));

        foreach ($anime as $k => $v) {
            $response[$v->id] = [
                'id' => $v->id,
                'title' => $v->title,
                'description' => $v->description,
                'image_url' => $v->image_url,
                'date' => $v->date,
                'shikimori' => $v->shikimori_rating,
                'world-art' => $v->worldart_rating,
                'image_name' => $v->image_name,
                'status' => 0 == $v->status ? "Онгоинг" : "Вышел",
                'company' => [
                    $v->company,
                ],
            ];

            foreach ($v->series as $key => $value) {
                $response[$v->id]['series'][] = $value->link_on_video;
            }

            foreach ($v->musicToAnime as $key => $value) {
                $response[$v->id]['soundtracks'][] = $value->music;
            }
        }

        return response()->json(
            $this->response->add('response', $response)->response(), 200
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
        $anime = $this->service->getAnime($id);
        $response = [];

        if (is_array($anime)) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Incorrect id of anime')->response(
                    'anime.incorrect_id'
                ), 406
            );
        }

        {
            $response = [
                'id' => $anime->id,
                'title' => $anime->title,
                'description' => $anime->description,
                'image_url' => $anime->image_url,
                'date' => $anime->date,
                'genres' => $anime->genres,
                'shikimori' => $anime->shikimori_rating,
                'world_art' => $anime->worldart_rating,
                'image_name' => $anime->image_name,
                'status' => 0 == $anime->status ? "Онгоинг" : "Вышел",
                'company' => $anime->company
            ];

            foreach ($anime->series as $key => $value) {
                $response['series'][] = ['source' => $value->link_on_video];
            }

            foreach ($anime->musicToAnime as $key => $value) {
                $response['soundtracks'][] = $value->music;
            }
        };

        return response()->json(
            $this->response->add('response', $response)->response(), 200
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function companyById(int $id): JsonResponse
    {
        $company = $this->service->getCompany($id);

        if (is_array($company)) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Incorrect id of company')->response(
                    'company.incorrect_id'
                ), 406
            );
        }

        return response()->json(
            $this->response->add('response', $company)->response(), 200
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function animeById(int $id): JsonResponse
    {
        $anime = $this->service->getAnimeForCompany($id);

        if (is_array($anime)) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Incorrect id of company')->response(
                    'company.incorrect_id'
                ), 406
            );
        }

        return response()->json(
            $this->response->add('response', $anime)->response(), 200
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function tracksById(int $id): JsonResponse
    {
        $music = $this->service->getSoundTracks($id);
        $result = [];

        if (is_array($music)) {
            return response()->json(
                $this->response->changeStatus()->add('response', 'Incorrect id of anime')->response(
                    'anime.soundtracks.incorrect_id'
                ), 406
            );
        }

        foreach ($music as $k => $v) {
            $result[] = $v->music;
        }

        return response()->json(
            $this->response->add('response', $result)->response(), 200
        );
    }
}