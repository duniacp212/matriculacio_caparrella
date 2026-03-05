<?php

namespace App\Controllers;

class ExpedientsController extends BaseController
{
    public function index()
    {
        return view('expedients/index');
    }
}