<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;

class HeroController extends Controller
{
  /**
   * @desc Afficher la partie Hero Section
   * @return Factory|View|\Illuminate\View\View
   */
  public function getHero()
  {
    $hero = Hero::find(1);
    return view('admin.backend.hero.get_hero', compact('hero'));
  }

  /**
   * @desc Mettre à jour la partie Hero Section de manière classique
   * @param Request $request
   * @return RedirectResponse
   */
  public function updateHero(Request $request)
  {
    $hero_id = $request->id;
    $hero = Hero::findOrFail($hero_id);

    if ($request->hasFile('image')) {
      $image = $request->file('image');

      // Intervention Image
      $manager = new ImageManager(new Driver());
      $name_generate = hexdec(uniqid()).".".$image->getClientOriginalExtension();
      $image_resize = $manager->read($image);
      $image_resize->resize(306, 618)
        ->save(public_path('upload/hero/'.$name_generate));
      $save_url = 'upload/hero/'.$name_generate;

      // Supprimer l'ancienne image si elle existe
      if ($hero->image && file_exists(public_path($hero->image))) {
        unlink(public_path($hero->image));
      }

      // Mise à jour en BDD avec la nouvelle image
      Hero::find($hero_id)->update([
        'title' => $request->title,
        'description' => $request->description,
        'link' => $request->link,
        'image' => $save_url,
      ]);

      $notification = array(
        'message' => 'Hero updated with image successfully!',
        'alert-type' => 'success'
      );
    } else {
      // Mise à jour en BDD sans image
      Hero::find($hero_id)->update([
        'title' => $request->title,
        'description' => $request->description,
        'link' => $request->link,
      ]);

      $notification = array(
        'message' => 'Hero updated without image successfully!',
        'alert-type' => 'success'
      );
    }

    return redirect()->back()->with($notification);
  }

  /**
   * @desc Mettre à jour le titre et la description directement dans l'interface
   * avec javascript
   * @param Request $request
   * @param $id
   * @return JsonResponse
   */
  public function editHero(Request $request, $id)
  {
    $hero = Hero::findOrFail($id);

    if ($request->has('title')) {
      $hero->title = $request->title;
    }

    if ($request->has('description')) {
      $hero->description = $request->description;
    }

    $hero->save();
    return response()->json(['success' => true]);
  }
}
