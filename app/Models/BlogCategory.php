<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogCategory extends Model
{
  protected $guarded = [];

  public function posts(): HasMany
  {
    return $this->hasMany(BlogPost::class, 'category_id');
  }
}
