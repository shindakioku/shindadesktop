<?php

namespace App\Http\Controllers;

use App\Entities\Group;
use App\Entities\Music;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminMusicController
{
    /**
     * @return View
     */
    public function viewAdd(): View
    {
        return view('music.add-view');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $music = new Music();

        $music->name = $request->name;
        $music->duration = $request->duration;
        $music->group_id = $request->group_id;
        $music->link_on_source = $request->source;

        if ($music->save()) {
            return response()->redirectTo('/add-music')->with('success');
        }

        return response()->redirectTo('/add-music')->withErrors('error..');
    }

    /**
     * @param string $name
     * @return View
     */
    public function edit(string $name): View
    {
        if (!($music = Music::where('name', $name)->first())) {
            return view('404');
        }

        return view('music.edit', compact('music'));
    }

    /**
     * @param string $name
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(string $name, Request $request): RedirectResponse
    {
        if (!($music = Music::where('name', $name)->first())) {
            return redirect()->to('/404');
        }

        $music->name = $request->name;
        $music->duration = $request->duration;
        $music->group_id = $request->group_id;
        $music->link_on_source = $request->source;

        if (!$music->save()) {
            return redirect()->back()->withErrors('error');
        }

        return redirect()->to('/music/'.$request->name);
    }

    /**
     * @return View
     */
    public function newGroupView(): View
    {
        return view('music.group-add');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function createNewGroup(Request $request): RedirectResponse
    {
        $group = new Group();

        $group->name = $request->name;
        $group->description = $request->description;
        $group->people = $request->date;
        $group->date = $request->date;

        if ($group->save()) {
            return response()->redirectTo('/music/new/group')->with('success');
        }

        return response()->redirectTo('/music/group/new')->withErrors('error..');
    }

    /**
     * @param string $name
     * @return View
     */
    public function editGroup(string $name): View
    {
        if (!($group = Group::where('name', $name)->first())) {
            return view('404');
        }

        return view('music.edit-group', compact('group'));
    }

    /**
     * @param string $name
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateGroup(string $name, Request $request): RedirectResponse
    {
        if (!($group = Group::where('name', $name)->first())) {
            return redirect()->to('/404');
        }

        $group->name = $request->name;
        $group->description = $request->description;
        $group->people = $request->date;
        $group->date = $request->date;

        if (!$group->save()) {
            return redirect()->back()->withErrors('error');
        }

        return redirect()->to('/music/group/'.$request->name);
    }
}