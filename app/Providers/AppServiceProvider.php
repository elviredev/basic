<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\BlogCategory;
use App\Models\BlogPost;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
      /**
       * @desc Déclarer une seule fois les catégories & les récents posts qui doivent être disponibles dans toutes les pages du blog
       */
        View::composer('home.blog.*', function ($view) {
          $categories = BlogCategory::latest()->withCount('posts')->get();

          // Pagination pour les articles principaux
          $posts = BlogPost::latest()->paginate(3);

          // 3 derniers posts (indépendants de la pagination)
          $recentsPost = BlogPost::latest()->limit(3)->get();

          $view->with(compact('categories', 'recentsPost', 'posts'));
        });
    }
}
