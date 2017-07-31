<?php

namespace App\Http\Controllers;

use App\Entities\Anime;
use App\Entities\AnimeSeries;
use App\Entities\Company;
use App\Entities\MusicToAnime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAnimeController
{
    /**
     * @return View
     */
    public function viewAdd(): View
    {
        return view('anime.add-view');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $anime = new Anime();

        $anime->title = $request->title;
        $anime->description = $request->description;
        $anime->image_url = $request->image_url;
        $anime->company_id = $request->company_id;
        $anime->date = $request->date;
        $anime->shikimori_rating = $request->shikimori;
        $anime->worldart_rating = $request->input('world-art');
        $anime->image_name = $request->image_name;
        $anime->status = $request->status;

        if ($anime->save()) {
            return response()->redirectTo('/add-anime')->with('success');
        }

        return response()->redirectTo('/add-anime')->withErrors('error..');
    }

    /**
     * @param string $name
     * @return View
     */
    public function edit(string $name): View
    {
        if (!($anime = Anime::where('title', $name)->first())) {
            return view('404');
        }

        return view('anime.edit', compact('anime'));
    }

    /**
     * @param string $name
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(string $name, Request $request): RedirectResponse
    {
        if (!($anime = Anime::where('title', $name)->first())) {
            return redirect()->to('/404');
        }

        $anime->title = $request->title;
        $anime->description = $request->description;
        $anime->image_url = $request->image_url;
        $anime->date = $request->date;
        $anime->company_id = $request->company_id;
        $anime->shikimori_rating = $request->shikimori;
        $anime->worldart_rating = $request->input('world-art');
        $anime->image_name = $request->image_name;
        $anime->status = $request->status;

        if (!$anime->save()) {
            return redirect()->back()->withErrors('error');
        }

        return redirect()->to('/anime/'.$request->title);
    }

    /**
     * @param string $name
     * @return View
     */
    public function seriesAddView(string $name): View
    {
        if (!($anime = Anime::where('title', $name)->first())) {
            return view('/404');
        }

        $series = AnimeSeries::where('anime_id', $anime->id)->get();

        return view(
            'anime.series', [
                'series' => $series,
                'title' => $anime->title,
                'anime_id' => $anime->id,
            ]
        );
    }

    /**
     * @param int $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function seriesSave(int $id, Request $request): RedirectResponse
    {
        $series = AnimeSeries::where('anime_id', $id)->get();
        $fromRequest = $request->series;
        $forUpdate = [];
        $forDelete = [];

        if (count($fromRequest) && $series) {
            foreach ($series as $k => $v) {
                if (array_key_exists($v->id, $fromRequest) && "0" == $fromRequest[$v->id]) {
                    $forDelete[] = $v->id;
                }

                if (!array_key_exists($v->id, $forDelete) && $v->link_on_video != ($value = $fromRequest[$v->id])) {
                    $forUpdate[] = [
                        'id' => $v->id,
                        'link_on_video' => $value,
                    ];
                }

            }
        }

        if (5 < strlen($request->series_link)) {
            $animeSeries = new AnimeSeries();

            $animeSeries->anime_id = $id;
            $animeSeries->link_on_video = $request->series_link;

            $animeSeries->save();
        }

        if (count($forUpdate)) {
            foreach ($forUpdate as $k => $v) {
                $animeSeries = AnimeSeries::findOrFail($v['id']);

                $animeSeries->link_on_video = $v['link_on_video'];

                $animeSeries->update();
            }
        }

        if (count($forDelete)) {
            AnimeSeries::whereIn('id', $forDelete)->delete();
        }

        return redirect()->to('/anime/'.$request->anime_title.'/series');
    }

    /**
     * @param string $name
     * @return View
     */
    public function soundAddView(string $name): View
    {
        if (!($anime = Anime::where('title', $name)->first())) {
            return view('/404');
        }

        $music = MusicToAnime::where('anime_id', $anime->id)->get();

        return view(
            'anime.soundtracks', [
                'music' => $music,
                'title' => $anime->title,
                'anime_id' => $anime->id,
            ]
        );
    }

    /**
     * @param int $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function soundSave(int $id, Request $request): RedirectResponse
    {
        $soundTracks = MusicToAnime::where('anime_id', $id)->get();
        $fromRequest = $request->music;
        $forUpdate = [];
        $forDelete = [];

        if (count($fromRequest) && $soundTracks) {
            foreach ($soundTracks as $k => $v) {
                if (array_key_exists($v->id, $fromRequest) && "0" == $fromRequest[$v->id]) {
                    $forDelete[] = $v->id;
                }

                if (!array_key_exists($v->id, $forDelete) && $v->music_id != ($value = $fromRequest[$v->id])) {
                    $forUpdate[] = [
                        'id' => $v->id,
                        'music_id' => $value,
                    ];
                }

            }
        }

        if (0 != strlen($request->music_new)) {
            $music = new MusicToAnime();

            $music->anime_id = $id;
            $music->music_id = $request->music_new;

            $music->save();
        }

        if (count($forUpdate)) {
            foreach ($forUpdate as $k => $v) {
                $music = MusicToAnime::findOrFail($v['id']);

                $music->music_id = $v['music_id'];

                $music->update();
            }
        }

        if (count($forDelete)) {
            MusicToAnime::whereIn('id', $forDelete)->delete();
        }

        return redirect()->to('/anime/'.$request->anime_title.'/soundtracks');
    }

    /**
     * @param string $name
     * @return View
     */
    public function companyView(string $name): View
    {
        if (!($company = Company::where('name', $name)->first())) {
            return view('/404');
        }

        return view('anime.company', compact('company'));
    }

    /**
     * @param string $name
     * @param Request $request
     * @return RedirectResponse
     */
    public function companyUpdate(string $name, Request $request): RedirectResponse
    {
        if (!($company = Company::where('name', $name)->first())) {
            return redirect()->to('/404');
        }

        $company->name = $request->name;
        $company->description = $request->description;
        $company->date = $company->date;

        $company->update();

        return redirect()->to('/anime/company/'.$request->name);
    }

    /**
     * @return View
     */
    public function companyCreateView(): View
    {
        return view('anime.company-create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function companyCreate(Request $request): RedirectResponse
    {
        $company = new Company();

        $company->name = $request->name;
        $company->date = $request->date;
        $company->description = $request->description;

        if ($company->save()) {
            return response()->redirectTo('/anime/company/'.$request->name);
        }

        return response()->redirectTo('/anime/company/new')->withErrors('error..');
    }
}