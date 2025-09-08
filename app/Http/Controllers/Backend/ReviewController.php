<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Review;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ReviewController extends Controller
{
  /**
   * @desc Affiche tous les avis clients dans le Dashboard Admin
   * @return Factory|View|\Illuminate\View\View
   */
  public function allReviews()
  {
    $reviews = Review::latest()->get();
    return view('admin.backend.reviews.all_reviews', compact('reviews'));
  }

  /**
   * @desc Affiche le formulaire d'ajout d'un avis
   * @return Factory|View|\Illuminate\View\View
   */
  public function addReview()
  {
    return view('admin.backend.reviews.add_review');
  }

  /**
   * @desc Sauvegarde l'avis en BDD
   * @param Request $request
   * @return RedirectResponse
   */
  public function storeReview(Request $request)
  {
    if ($request->hasFile('image')) {
      $image = $request->file('image');

      // Intervention Image
      $manager = new ImageManager(new Driver());
      $name_generate = hexdec(uniqid()).".".$image->getClientOriginalExtension();
      $image_resize = $manager->read($image);
      $image_resize->resize(60, 60)
                   ->save(public_path('upload/review/'.$name_generate));
      $save_url = 'upload/review/'.$name_generate;

      // Enregistrer l'avis en BDD
      Review::create([
        'name' => $request->name,
        'position' => $request->position,
        'message' => $request->message,
        'image' => $save_url,
      ]);
    }

    $notification = array(
      'message' => 'Review added successfully!',
      'alert-type' => 'success'
    );

    return redirect()->route('all.reviews')->with($notification);
  }

  /**
   * @desc Affiche le formulaire d'édition d'un avis
   * @param $id
   * @return Factory|View|\Illuminate\View\View
   */
  public function editReview($id)
  {
    $review = Review::findOrFail($id);
    return view('admin.backend.reviews.edit_review', compact('review'));
  }

  /**
   * @desc Mettre à jour un avis utilisateur
   * @param Request $request
   * @return RedirectResponse
   */
  public function updateReview(Request $request)
  {
    $review_id = $request->id;
    $review = Review::findOrFail($review_id);

    if ($request->hasFile('image')) {
      $image = $request->file('image');

      // Intervention Image
      $manager = new ImageManager(new Driver());
      $name_generate = hexdec(uniqid()).".".$image->getClientOriginalExtension();
      $image_resize = $manager->read($image);
      $image_resize->resize(60, 60)
        ->save(public_path('upload/review/'.$name_generate));
      $save_url = 'upload/review/'.$name_generate;

      // Supprimer l'ancienne image si elle existe
      if ($review->image && file_exists(public_path($review->image))) {
        unlink(public_path($review->image));
      }

      // Mise à jour en BDD avec la nouvelle image
      Review::find($review_id)->update([
        'name' => $request->name,
        'position' => $request->position,
        'message' => $request->message,
        'image' => $save_url,
      ]);

      $notification = array(
        'message' => 'Review updated with image successfully!',
        'alert-type' => 'success'
      );
    } else {
      // Mise à jour en BDD sans image
      Review::find($review_id)->update([
        'name' => $request->name,
        'position' => $request->position,
        'message' => $request->message,
      ]);

      $notification = array(
        'message' => 'Review updated without image successfully!',
        'alert-type' => 'success'
      );
    }

    return redirect()->route('all.reviews')->with($notification);
  }

  /**
   * @desc Supprimer un avis utilisateur
   * @param $id
   * @return RedirectResponse
   */
  public function deleteReview($id)
  {
    $item = Review::findOrFail($id);
    $image = $item->image;
    unlink($image);

    Review::findOrFail($id)->delete();

    $notification = array(
      'message' => 'Review deleted successfully!',
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  }
}
