<?php

namespace App\Controllers;

class IniciController extends BaseController
{
  public function index()
{
    return view('inici/index', [
        'title' => 'Inici'
    ]);
}



}
