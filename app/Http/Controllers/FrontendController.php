<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\About;

class FrontendController extends Controller
{
  public function ourTeam()
  {
    return view('home.team.team_page');
  }

  public function aboutUs()
  {
    return view('home.about.about_us');
  }


  /**
   * @desc Afficher la partie About Us Section
   * @return \Illuminate\View\View
   */
  public function getAbout()
  {
    $about = About::find(1);
    return view('admin.backend.about.get_about', compact('about'));
  }

  /**
   * @desc Mettre à jour la partie About Section
   * @param Request $request
   * @return RedirectResponse
   */
  public function updateAbout(Request $request)
  {
    $about_id = $request->id;
    $about = About::findOrFail($about_id);

    if ($request->hasFile('image')) {
      $image = $request->file('image');

      // Intervention Image
      $manager = new ImageManager(new Driver());
      $name_generate = hexdec(uniqid()).".".$image->getClientOriginalExtension();
      $image_resize = $manager->read($image);
      $image_resize->resize(526, 550)
        ->save(public_path('upload/about/'.$name_generate));
      $save_url = 'upload/about/'.$name_generate;

      // Supprimer l'ancienne image si elle existe
      if ($about->image && file_exists(public_path($about->image))) {
        unlink(public_path($about->image));
      }

      // Mise à jour en BDD avec la nouvelle image
      About::find($about_id)->update([
        'title' => $request->title,
        'description' => $request->description,
        'image' => $save_url,
      ]);

      $notification = array(
        'message' => 'About Page updated with image successfully!',
        'alert-type' => 'success'
      );
    } else {
      // Mise à jour en BDD sans image
      About::find($about_id)->update([
        'title' => $request->title,
        'description' => $request->description,
      ]);

      $notification = array(
        'message' => 'About Page updated without image successfully!',
        'alert-type' => 'success'
      );
    }

    return redirect()->back()->with($notification);
  }

}
