<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
  protected $guarded = [];

  public function blog(): BelongsTo
  {
    return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
  }
}
