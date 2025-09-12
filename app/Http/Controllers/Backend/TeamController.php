<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Team;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TeamController extends Controller
{
  /**
   * @desc Affiche toutes les équipes dans le Dashboard Admin
   * @return Factory|View|\Illuminate\View\View
   */
  public function allTeams()
  {
    $teams = Team::latest()->get();
    return view('admin.backend.teams.all_teams', compact('teams'));
  }

  /**
   * @desc Affiche le formulaire d'ajout d'une équipe
   * @return Factory|View|\Illuminate\View\View
   */
  public function addTeam()
  {
    return view('admin.backend.teams.add_team');
  }

  /**
   * @desc Sauvegarde l'équipe en BDD
   * @param Request $request
   * @return RedirectResponse
   */
  public function storeTeam(Request $request)
  {
    // Image par défaut si aucune image n'est fournie
    $default_img = 'upload/team/no_image.jpg';

    $save_url = $default_img; // Valeur par défaut si pas d'image

    if ($request->hasFile('image')) {
      $image = $request->file('image');

      // Intervention Image
      $manager = new ImageManager(new Driver());
      $name_generate = hexdec(uniqid()).".".$image->getClientOriginalExtension();
      $image_resize = $manager->read($image);
      $image_resize->resize(306, 400)
        ->save(public_path('upload/team/'.$name_generate));
      $save_url = 'upload/team/'.$name_generate;
    }

    // Enregistrer l'équipe en BDD avec ou sans image
    Team::create([
      'name' => $request->name,
      'position' => $request->position,
      'image' => $save_url,
    ]);

    $notification = array(
      'message' => 'Team added successfully!',
      'alert-type' => 'success'
    );

    return redirect()->route('all.teams')->with($notification);
  }

  /**
   * @desc Affiche le formulaire d'édition d'une équipe
   * @param $id
   * @return Factory|View|\Illuminate\View\View
   */
  public function editTeam($id)
  {
    $team = Team::findOrFail($id);
    return view('admin.backend.teams.edit_team', compact('team'));
  }

  /**
   * @desc Mettre à jour une équipe
   * @param Request $request
   * @return RedirectResponse
   */
  public function updateTeam(Request $request)
  {
    $team_id = $request->id;
    $team = Team::findOrFail($team_id);

    if ($request->hasFile('image')) {
      $image = $request->file('image');

      // Intervention Image
      $manager = new ImageManager(new Driver());
      $name_generate = hexdec(uniqid()).".".$image->getClientOriginalExtension();
      $image_resize = $manager->read($image);
      $image_resize->resize(306, 400)
        ->save(public_path('upload/team/'.$name_generate));
      $save_url = 'upload/team/'.$name_generate;

      // Supprimer l'ancienne image si elle existe sauf si c'est l'image par défaut
      if ($team->image && $team->image !== 'upload/team/no_image.jpg' && file_exists(public_path($team->image))) {
        unlink(public_path($team->image));
      }

      // Mise à jour en BDD avec la nouvelle image
      Team::find($team_id)->update([
        'name' => $request->name,
        'position' => $request->position,
        'image' => $save_url,
      ]);

      $notification = array(
        'message' => 'Team member updated with image successfully!',
        'alert-type' => 'success'
      );
    } else {
      // Mise à jour en BDD sans image
      Team::find($team_id)->update([
        'name' => $request->name,
        'position' => $request->position,
      ]);

      $notification = array(
        'message' => 'Team member updated without image successfully!',
        'alert-type' => 'success'
      );
    }

    return redirect()->route('all.teams')->with($notification);
  }

  /**
   * @desc Supprimer une équipe
   * @param $id
   * @return RedirectResponse
   */
  public function deleteTeam($id)
  {
    $item = Team::findOrFail($id);

    // Supprimer old image sauf si c'est image par défaut
    if (
      !empty($item->image) &&
      $item->image !== 'upload/team/no_image.jpg' &&
      file_exists(public_path($item->image))
    ) {
      unlink(public_path($item->image));
    }

    Team::findOrFail($id)->delete();

    $notification = array(
      'message' => 'Team member deleted successfully!',
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  }


}
