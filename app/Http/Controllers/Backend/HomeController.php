<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Process;
use App\Models\Tab;
use App\Models\ToolQuality;
use App\Models\VideoSection;
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

  /** =============== Video Section =============== */

  /**
   * @desc Afficher la partie Video Section
   * @return Factory|View|\Illuminate\View\View
   */
  public function getVideo()
  {
    $video = VideoSection::find(1);
    return view('admin.backend.video_section.get_video', compact('video'));
  }

  /**
   * @desc Mettre à jour la partie Video Section
   * @param Request $request
   * @return RedirectResponse
   */
  public function updateVideo(Request $request)
  {
    $video_id = $request->id;
    $video = VideoSection::findOrFail($video_id);

    if ($request->hasFile('image')) {
      $image = $request->file('image');

      // Intervention Image
      $manager = new ImageManager(new Driver());
      $name_generate = hexdec(uniqid()).".".$image->getClientOriginalExtension();
      $image_resize = $manager->read($image);
      $image_resize->resize(560, 400)
        ->save(public_path('upload/video_section/'.$name_generate));
      $save_url = 'upload/video_section/'.$name_generate;

      // Supprimer l'ancienne image si elle existe
      if ($video->image && file_exists(public_path($video->image))) {
        unlink(public_path($video->image));
      }

      // Mise à jour en BDD avec la nouvelle image
      VideoSection::find($video_id)->update([
        'title' => $request->title,
        'description' => $request->description,
        'youtube' => $request->youtube,
        'link' => $request->link,
        'image' => $save_url,
      ]);

      $notification = array(
        'message' => 'Video Section updated with image successfully!',
        'alert-type' => 'success'
      );
    } else {
      // Mise à jour en BDD sans image
      VideoSection::find($video_id)->update([
        'title' => $request->title,
        'description' => $request->description,
        'youtube' => $request->youtube,
        'link' => $request->link,
      ]);

      $notification = array(
        'message' => 'Video Section updated without image successfully!',
        'alert-type' => 'success'
      );
    }
    return redirect()->back()->with($notification);
  }

  /** =============== Process Section =============== */

  /**
   * @desc Affiche tous les Process dans le Dashboard Admin
   * @return Factory|View|\Illuminate\View\View
   */
  public function allProcess()
  {
    $process = Process::latest()->get();
    return view('admin.backend.process_section.all_process', compact('process'));
  }

  /**
   * @desc Affiche le formulaire d'ajout d'un process
   * @return Factory|View|\Illuminate\View\View
   */
  public function addProcess()
  {
    return view('admin.backend.process_section.add_process');
  }

  /**
   * @desc Sauvegarde le process en BDD
   * @param Request $request
   * @return RedirectResponse
   */
  public function storeProcess(Request $request)
  {
    // Enregistrer la feature en BDD
    Process::create([
      'title' => $request->title,
      'description' => $request->description,
    ]);

    $notification = array(
      'message' => 'Process Section added successfully!',
      'alert-type' => 'success'
    );

    return redirect()->route('all.process')->with($notification);
  }

  /**
   * @desc Affiche le formulaire d'édition d'un process
   * @param $id
   * @return Factory|View|\Illuminate\View\View
   */
  public function editProcess($id)
  {
    $process = Process::findOrFail($id);
    return view('admin.backend.process_section.edit_process', compact('process'));
  }

  /**
   * @desc Met à jour un process en BDD
   * @param Request $request
   * @return RedirectResponse
   */
  public function updateProcess(Request $request)
  {
    $process_id = $request->id;

    // Modifier le process en BDD
    Process::findOrFail($process_id)->update([
      'title' => $request->title,
      'description' => $request->description,
    ]);

    $notification = array(
      'message' => 'Process updated successfully!',
      'alert-type' => 'success'
    );

    return redirect()->route('all.process')->with($notification);
  }

  /**
   * @desc Supprimer un process
   * @param $id
   * @return RedirectResponse
   */
  public function deleteProcess($id)
  {
    Process::findOrFail($id)->delete();

    $notification = array(
      'message' => "Process deleted successfully!",
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  }

  /**
   * @desc Modifie les données via l'interface avec javascript
   * @param Request $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateProcessData(Request $request, $id)
  {
    $process = Process::findOrFail($id);

    $process->update($request->only('title', 'description'));
    return response()->json(['success' => true, 'message' => 'Updated successfully']);
  }

}
