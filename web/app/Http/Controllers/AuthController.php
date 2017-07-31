<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController
{
    /**
     * @return View
     */
    public function view(): View
    {
        return view('auth');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function auth(Request $request): RedirectResponse
    {
        if ($request->login == 'shinda' && $request->password = '12jqwke1237asdk123') {
            Auth::loginUsingId(1);
        }

        return redirect()->to('/add-anime');
    }
}