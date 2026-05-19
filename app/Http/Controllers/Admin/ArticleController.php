<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
  public function index(Request $request)
{
    $search = $request->input('search');
    $category = $request->input('category');
    $language = session('admin_product_language', 'pt');

    $articles = Article::query()
        ->where('language', $language)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%');
            });
        })
        ->when($category, function ($query) use ($category) {
            $query->where('category', $category);
        })
        ->orderBy('article_date', 'desc')
        ->orderBy('article_id', 'desc')
        ->paginate(15)
        ->withQueryString();

    return view('admin.articles.index', compact('articles', 'search', 'category', 'language'));
}

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'article_date' => ['nullable', 'date'],
            'detail' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'language' => ['nullable', 'string', 'max:20'],
            'translation_key' => ['nullable', 'string', 'max:255'],
            
        ]);

        $coverPath = null;

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('articles/cover', 'public');
        }

        $language = session('admin_product_language', 'pt');

        Article::create([
            'title' => $request->title,
            'category' => $request->category,
            'article_date' => $request->article_date,
            'detail' => $request->detail,
            'cover_image' => $coverPath,
            'is_active' => $request->has('is_active') ? 1 : 0,
             'description' => $request->description,
             'language' => $language,
             'translation_key' => $request->translation_key ?: \Illuminate\Support\Str::slug($request->title) . '_' . time(),
        ]);

        $this->forgetHomeCache();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article created successfully.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'article_date' => ['nullable', 'date'],
            'detail' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'translation_key' => ['nullable', 'string', 'max:255'],
        ]);

        $coverPath = $article->cover_image;

        if ($request->hasFile('cover_image')) {
            if ($coverPath && Storage::disk('public')->exists($coverPath)) {
                Storage::disk('public')->delete($coverPath);
            }

            $coverPath = $request->file('cover_image')->store('articles/cover', 'public');
        }

        $article->update([
            'title' => $request->title,
            'category' => $request->category,
            'article_date' => $request->article_date,
            'detail' => $request->detail,
            'cover_image' => $coverPath,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'description' => $request->description,
            'translation_key' => $request->translation_key ?: $article->translation_key,
        ]);

        $this->forgetHomeCache();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        if ($article->cover_image && Storage::disk('public')->exists($article->cover_image)) {
            Storage::disk('public')->delete($article->cover_image);
        }

        $article->delete();

        $this->forgetHomeCache();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }

    public function uploadEditorImage(Request $request)
    {
        $request->validate([
            'upload' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
        ]);

        $path = $request->file('upload')->store('articles/editor', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }

    private function forgetHomeCache(): void
    {
        foreach (['pt', 'ja', 'en'] as $language) {
            \Illuminate\Support\Facades\Cache::forget('home_page_data_' . $language);
        }

        \Illuminate\Support\Facades\Cache::forget('home_page_data');
    }
}
