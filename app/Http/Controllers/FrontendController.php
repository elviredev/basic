<?php

namespace App\Http\Controllers;

class FrontendController extends Controller
{
  public function ourTeam()
  {
    return view('home.team.team_page');
  }
}
