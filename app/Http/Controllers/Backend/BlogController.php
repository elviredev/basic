<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BlogController extends Controller
{
  /** =============== Blog Category =============== */

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
   * @return RedirectResponse
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
   * @return RedirectResponse
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

  /**
   * @desc Supprimer une catégorie
   * @param $id
   * @return RedirectResponse
   */
  public function deleteBlogCategory($id)
  {
    BlogCategory::findOrFail($id)->delete();

    $notification = array(
      'message' => 'Blog Category deleted successfully!',
      'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);
  }

  /** =============== Blog Posts =============== */

  /**
   * @desc Récupère et affiche les articles
   * @return \Illuminate\View\View
   */
  public function allBlogPosts()
  {
    $posts = BlogPost::latest()->get();
    return view('admin.backend.blogpost.all_posts', compact('posts'));
  }

  /**
   * @desc Afficher les catégories dans la vue add_post
   * @return \Illuminate\View\View
   */
  public function addBlogPost()
  {
    $categories = BlogCategory::latest()->get();
    return view('admin.backend.blogpost.add_post', compact('categories'));
  }

  /**
   * @desc Sauvegarde un article en BDD
   * @param Request $request
   * @return RedirectResponse
   */
  public function storeBlogPost(Request $request)
  {
    // ✅ Validation des champs
    $request->validate([
      'category_id' => 'required|exists:blog_categories,id',
      'title'       => 'required|string|max:255|unique:blog_posts,title',
      'description' => 'required|string',
      'image'       => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
    ], [
      'category_id.required' => 'La catégorie est obligatoire.',
      'category_id.exists'   => 'La catégorie sélectionnée est invalide.',
      'title.required'       => 'Le titre est obligatoire.',
      'title.unique'         => 'Ce titre existe déjà.',
      'description.required' => 'La description est obligatoire.',
      'image.required'       => 'L’image est obligatoire.',
      'image.image'          => 'Le fichier doit être une image.',
      'image.mimes'          => 'L’image doit être au format jpg, jpeg, png, gif ou webp.',
      'image.max'            => 'L’image ne doit pas dépasser 2 Mo.',
    ]);


    if ($request->hasFile('image')) {
      $image = $request->file('image');

      // Intervention Image
      $manager = new ImageManager(new Driver());
      $name_generate = hexdec(uniqid()).".".$image->getClientOriginalExtension();
      $image_resize = $manager->read($image);
      $image_resize->resize(746, 500)
        ->save(public_path('upload/blog_posts/'.$name_generate));
      $save_url = 'upload/blog_posts/'.$name_generate;

      // Enregistrer l'avis en BDD
      BlogPost::create([
        'category_id' => $request->category_id,
        'title' => $request->title,
        'slug' => strtolower(str_replace(' ', '-', $request->title)),
        'description' => $request->description,
        'image' => $save_url,
      ]);
    }

    $notification = array(
      'message' => 'Post added successfully!',
      'alert-type' => 'success'
    );

    return redirect()->route('all.blog.posts')->with($notification);
  }

  /**
   * @desc Afficher le formulaire d'édition avec les données pré-remplies
   * @param $id
   * @return \Illuminate\View\View
   */
  public function editBlogPost($id)
  {
    $categories = BlogCategory::latest()->get();
    $post = BlogPost::findOrFail($id);
    return view('admin.backend.blogpost.edit_post', compact('post', 'categories'));
  }

  /**
   * @desc Mettre à jour un article de blog
   * @param Request $request
   * @return RedirectResponse
   */
  public function updateBlogPost(Request $request)
  {
    $post_id = $request->id;
    $post = BlogPost::findOrFail($post_id);

    if ($request->hasFile('image')) {
      $image = $request->file('image');

      // Intervention Image
      $manager = new ImageManager(new Driver());
      $name_generate = hexdec(uniqid()).".".$image->getClientOriginalExtension();
      $image_resize = $manager->read($image);
      $image_resize->resize(746, 500)
        ->save(public_path('upload/blog_posts/'.$name_generate));
      $save_url = 'upload/blog_posts/'.$name_generate;

      // Supprimer l'ancienne image si elle existe
      if ($post->image && file_exists(public_path($post->image))) {
        unlink(public_path($post->image));
      }

      // Mise à jour en BDD avec la nouvelle image
      BlogPost::find($post_id)->update([
        'category_id' => $request->category_id,
        'title' => $request->title,
        'slug' => strtolower(str_replace(' ', '-', $request->title)),
        'description' => $request->description,
        'image' => $save_url,
      ]);

      $notification = array(
        'message' => 'Post updated with image successfully!',
        'alert-type' => 'success'
      );
    } else {
      // Mise à jour en BDD sans modification de l'image
      BlogPost::find($post_id)->update([
        'category_id' => $request->category_id,
        'title' => $request->title,
        'slug' => strtolower(str_replace(' ', '-', $request->title)),
        'description' => $request->description,
      ]);

      $notification = array(
        'message' => 'Post updated without image successfully!',
        'alert-type' => 'success'
      );
    }

    return redirect()->route('all.blog.posts')->with($notification);
  }

  /**
   * @desc Supprimer un article de blog
   * @param $id
   * @return RedirectResponse
   */
  public function deleteBlogPost($id)
  {
    $item = BlogPost::findOrFail($id);

    // Supprimer old image sauf si c'est image par défaut
    if (
      !empty($item->image) &&
      $item->image !== 'upload/no_image.jpg' &&
      file_exists(public_path($item->image))
    ) {
      unlink(public_path($item->image));
    }

    BlogPost::findOrFail($id)->delete();

    $notification = array(
      'message' => 'Post deleted successfully!',
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  }

}
