<?php

declare(strict_types=1);
namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryObserver
{
    public function creating(Category $category) : void
    {
        $category->url = Str::slug($category->title, '-');
    }

    public function updating(Category $category) : void
    {
        $category->url = Str::slug($category->title, '-');
    }

}
