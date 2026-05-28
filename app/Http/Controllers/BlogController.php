<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');
        $sort = $request->input('sort', 'latest');
        $langKey = $this->getLangKey();

        $categories = Article::query()
            ->where('language', $langKey)
            ->where('is_active', 1)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $articles = Article::query()
            ->where('language', $langKey)
            ->where('is_active', 1)
            ->when($category, function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->when($sort === 'oldest', function ($query) {
                $query->orderBy('article_date', 'asc')
                    ->orderBy('article_id', 'asc');
            })
            ->when($sort !== 'oldest', function ($query) {
                $query->orderBy('article_date', 'desc')
                    ->orderBy('article_id', 'desc');
            })
            ->paginate(9)
            ->withQueryString();

        return view('blog.index', compact(
            'articles',
            'categories',
            'category',
            'sort',
            'langKey'
        ));
    }

    public function show(Article $article)
    {
        $langKey = $this->getLangKey();

        if ((int) $article->is_active !== 1) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | ถ้า article ที่เปิดอยู่ไม่ใช่ภาษาปัจจุบัน
        | ให้หา article ภาษาใหม่จาก translation_key เดียวกัน
        |--------------------------------------------------------------------------
        */
        if (($article->language ?? 'pt') !== $langKey) {
            if (! empty($article->translation_key)) {
                $translatedArticle = Article::where('translation_key', $article->translation_key)
                    ->where('language', $langKey)
                    ->where('is_active', 1)
                    ->first();

                if ($translatedArticle) {
                    return redirect()->route('blog.show', [
                        'article' => $translatedArticle->article_id,
                    ]);
                }
            }

            return redirect()->route('blog.index');
        }

        return view('blog.show', compact('article', 'langKey'));
    }
}
