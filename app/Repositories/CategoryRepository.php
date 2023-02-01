<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Category;
use App\Models\CategoryArticle;
use App\Models\User;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll(): Collection
    {
        return Category::all();
    }

    public function getUserCategories(User $user): Collection
    {
        return $user->categories();
    }

    public function getCategoriesForArticleCollection(Collection $articles): Collection
    {
        $categories = collect();
        foreach ($articles as $article) {
            $articleCategories = $this->getArticleCategories($article);
            $categories->push($articleCategories);
        }
        return $categories;
    }

    public function getArticleCategories(Article $article): Collection
    {
        $categoryArticleIds = CategoryArticle::where('article_id', $article->id)->get();
        $categories = collect();

        foreach ($categoryArticleIds as $categoryArticle) {
            $category = Category::find($categoryArticle->category_id);
            $categories->push($category);
        }
        return $categories;
    }
}
