<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\About;

class FrontendController extends Controller
{
  /**
   * @desc Afficher la page Team
   * @return \Illuminate\View\View
   */
  public function ourTeam()
  {
    return view('home.team.team_page');
  }

  /**
   * @desc Afficher la page About
   * @return \Illuminate\View\View
   */
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

  /**
   * @desc Afficher la page Blog avec les catégories
   * @return \Illuminate\View\View
   */
  public function blogPage()
  {
    return view('home.blog.list_blog');
  }

  /**
   * @desc Affiche le détail d'un article
   * @param $slug
   * @return \Illuminate\View\View
   */
  public function blogDetails($slug)
  {
    $post = BlogPost::where('slug', $slug)->firstOrFail();
    return view('home.blog.blog_details', compact('post'));
  }

  /**
   * @desc Afficher les articles reliés à une catégorie
   * @param $id
   * @return \Illuminate\View\View
   */
  public function blogCategory($id)
  {
    $postsCategory = BlogPost::where('category_id', $id)
      ->latest()
      ->paginate(3);

    $category = BlogCategory::where('id', $id)->firstOrFail();
    return view('home.blog.blog_category', compact('postsCategory', 'category'));
  }

}
