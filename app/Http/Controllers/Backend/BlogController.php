<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;

class BlogController extends Controller
{
  /**
   * @desc Récupère et affiche les catégories
   * @return \Illuminate\View\View
   */
  public function blogCategory()
  {
    $categories = BlogCategory::latest()->get();
    return view('admin.backend.blogcategory.blog_category', compact('categories'));
  }

  /**
   * @desc Enregistrer les données en BDD
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function storeBlogCategory(Request $request)
  {
    BlogCategory::insert([
      'category_name' => $request->category_name,
      'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
    ]);

    $notification = array(
      'message' => 'Blog Category added successfully!',
      'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);
  }

  /**
   * @desc Récupère la catégorie et l'affiche dans le form d'édition
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function editBlogCategory($id)
  {
    $category = BlogCategory::findOrFail($id);
    return response()->json($category);
  }

  /**
   * @desc Mettre à jour une catégorie
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function updateBlogCategory(Request $request)
  {
    $cat_id = $request->cat_id;

    BlogCategory::findOrFail($cat_id)->update([
      'category_name' => $request->category_name,
      'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
    ]);

    $notification = array(
      'message' => 'Blog Category updated successfully!',
      'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);
  }

  public function deleteBlogCategory($id)
  {
    BlogCategory::findOrFail($id)->delete();

    $notification = array(
      'message' => 'Blog Category deleted successfully!',
      'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);
  }
}
