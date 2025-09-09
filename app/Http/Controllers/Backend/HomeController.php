<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Tab;
use App\Models\ToolQuality;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class HomeController extends Controller
{
  /** =============== Features Section =============== */


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
  public function addFeature()
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

  /** =============== Tool Quality Section =============== */

  /**
   * @desc Afficher la partie Tool Quality Section
   * @return Factory|View|\Illuminate\View\View
   */
  public function getTool()
  {
    $tool = ToolQuality::find(1);
    return view('admin.backend.tool_quality.get_tool', compact('tool'));
  }

  /**
   * @desc Mettre à jour la partie Tool Quality Section
   * @param Request $request
   * @return RedirectResponse
   */
  public function updateTool(Request $request)
  {
    $tool_id = $request->id;
    $tool = ToolQuality::findOrFail($tool_id);

    if ($request->hasFile('image')) {
      $image = $request->file('image');

      // Intervention Image
      $manager = new ImageManager(new Driver());
      $name_generate = hexdec(uniqid()).".".$image->getClientOriginalExtension();
      $image_resize = $manager->read($image);
      $image_resize->resize(302, 618)
        ->save(public_path('upload/tool_quality/'.$name_generate));
      $save_url = 'upload/tool_quality/'.$name_generate;

      // Supprimer l'ancienne image si elle existe
      if ($tool->image && file_exists(public_path($tool->image))) {
        unlink(public_path($tool->image));
      }

      // Mise à jour en BDD avec la nouvelle image
      ToolQuality::find($tool_id)->update([
        'title' => $request->title,
        'description' => $request->description,
        'image' => $save_url,
      ]);

      $notification = array(
        'message' => 'Tool Quality Section updated with image successfully!',
        'alert-type' => 'success'
      );
    } else {
      // Mise à jour en BDD sans image
      ToolQuality::find($tool_id)->update([
        'title' => $request->title,
        'description' => $request->description,
      ]);

      $notification = array(
        'message' => 'Tool Quality Section updated without image successfully!',
        'alert-type' => 'success'
      );
    }

    return redirect()->back()->with($notification);
  }

  /** =============== Tabs Section =============== */

  /**
   * @desc Afficher la partie Tabs Section
   * @return Factory|View|\Illuminate\View\View
   */
  public function getTabs()
  {
    $tabs = Tab::find(1);
    return view('admin.backend.tabs.get_tabs', compact('tabs'));
  }

  /**
   * @desc Mettre à jour la partie Tabs Section
   * @param Request $request
   * @return RedirectResponse
   */
  public function updateTabs(Request $request)
  {
    $tabs_id = $request->id;
    $tabs = Tab::findOrFail($tabs_id);

    if ($request->hasFile('image')) {
      $image = $request->file('image');

      // Intervention Image
      $manager = new ImageManager(new Driver());
      $name_generate = hexdec(uniqid()).".".$image->getClientOriginalExtension();
      $image_resize = $manager->read($image);
      $image_resize->resize(307, 619)
        ->save(public_path('upload/tabs/'.$name_generate));
      $save_url = 'upload/tabs/'.$name_generate;

      // Supprimer l'ancienne image si elle existe
      if ($tabs->image && file_exists(public_path($tabs->image))) {
        unlink(public_path($tabs->image));
      }

      // Mise à jour en BDD avec la nouvelle image
      Tab::find($tabs_id)->update([
        'title' => $request->title,
        'description' => $request->description,
        'tab_one_title' => $request->tab_one_title,
        'tab_one_content' => $request->tab_one_content,
        'tab_two_title' => $request->tab_two_title,
        'tab_two_content' => $request->tab_two_content,
        'image' => $save_url,
      ]);

      $notification = array(
        'message' => 'Tabs Section updated with image successfully!',
        'alert-type' => 'success'
      );
    } else {
      // Mise à jour en BDD sans image
      Tab::find($tabs_id)->update([
        'title' => $request->title,
        'description' => $request->description,
        'tab_one_title' => $request->tab_one_title,
        'tab_one_content' => $request->tab_one_content,
        'tab_two_title' => $request->tab_two_title,
        'tab_two_content' => $request->tab_two_content
      ]);

      $notification = array(
        'message' => 'Tabs Section updated without image successfully!',
        'alert-type' => 'success'
      );
    }
    return redirect()->back()->with($notification);
  }

}
