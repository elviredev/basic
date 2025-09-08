<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Title;

class TitleController extends Controller
{
  /**
   * @desc Mettre à jour le titre <h2> directement dans la homepage
   * avec javascript
   * @param Request $request
   * @param $id
   * @return JsonResponse
   */
  public function editFeatures(Request $request, $id)
  {
    $title = Title::findOrFail($id);

    if ($request->has('features')) {
      $title->features = $request->features;
    }

    $title->save();
    return response()->json(['success' => true]);
  }

  /**
   * @desc Mettre à jour le titre <h2> directement dans la homepage
   * avec javascript
   * @param Request $request
   * @param $id
   * @return JsonResponse
   */
  public function editReviews(Request $request, $id)
  {
    $title = Title::findOrFail($id);

    if ($request->has('reviews')) {
      $title->reviews = $request->reviews;
    }

    $title->save();
    return response()->json(['success' => true]);
  }

  /**
   * @desc Mettre à jour le titre <h2> directement dans la homepage
   * avec javascript
   * @param Request $request
   * @param $id
   * @return JsonResponse
   */
  public function editFaq(Request $request, $id)
  {
    $title = Title::findOrFail($id);

    if ($request->has('faq')) {
      $title->faq = $request->faq;
    }

    $title->save();
    return response()->json(['success' => true]);
  }


}
