<?php

namespace App\Http\Controllers;

use App\Entities\AnimeSeries;

class ProgramController
{
    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function videoPlayer(int $id)
    {
        $series = AnimeSeries::where('anime_id', $id)->get();

        if (0 === count($series)) {
            return response()->json(['error' => true, 'response' => 'Нету серий']);
        }

        return view('program.video', compact('series'));
    }
}