<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Catégories racines (optionnellement filtrées par famille) ou enfants d'un parent.
     */
    public function index(Request $request)
    {
        $query = Category::where('actif', true);

        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->get('parent_id'));
        } else {
            $query->whereNull('parent_id');
        }

        if ($famille = $request->get('famille')) {
            $query->where('famille', $famille);
        }

        return CategoryResource::collection($query->orderBy('ordre')->get());
    }
}
