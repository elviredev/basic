<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * @desc Affiche toutes les Features dans le Dashboard Admin
   * @return Factory|View|\Illuminate\View\View
   */
  public function allFeatures()
  {
    $features = Feature::latest()->get();
    return view('admin.backend.features.all_features', compact('features'));
  }

  /**
   * @desc Affiche le formulaire d'ajout d'une feature
   * @return Factory|View|\Illuminate\View\View
   */
  public function addFeature(Request $request)
  {
    return view('admin.backend.features.add_feature');
  }

  /**
   * @desc Sauvegarde la feature en BDD
   * @param Request $request
   * @return RedirectResponse
   */
  public function storeFeature(Request $request)
  {
    // Enregistrer la feature en BDD
    Feature::create([
      'title' => $request->title,
      'icon' => $request->icon,
      'description' => $request->description,
    ]);

    $notification = array(
      'message' => 'Feature added successfully!',
      'alert-type' => 'success'
    );

    return redirect()->route('all.features')->with($notification);
  }

  /**
   * @desc Affiche le formulaire d'édition d'une feature
   * @param $id
   * @return Factory|View|\Illuminate\View\View
   */
  public function editFeature($id)
  {
    $feature = Feature::findOrFail($id);
    return view('admin.backend.features.edit_feature', compact('feature'));
  }

/**
* @desc Met à jour la feature en BDD
* @param Request $request
* @return RedirectResponse
*/
  public function updateFeature(Request $request)
  {
    $feature_id = $request->id;

    // Modifier la feature en BDD
    Feature::findOrFail($feature_id)->update([
      'title' => $request->title,
      'icon' => $request->icon,
      'description' => $request->description,
    ]);

    $notification = array(
      'message' => 'Feature updated successfully!',
      'alert-type' => 'success'
    );

    return redirect()->route('all.features')->with($notification);
  }

  /**
   * @desc Supprimer une feature
   * @param $id
   * @return RedirectResponse
   */
  public function deleteFeature($id)
  {
    Feature::findOrFail($id)->delete();

    $notification = array(
      'message' => 'Feature deleted successfully!',
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  }

}
