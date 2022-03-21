<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;


class CategoryController extends Controller
{
    public function category($id)
    {
        if ($category = Category::find($id)) {
            return ['data' => $category];
        } else {
            return response()->json([
                'message' => 'No category found with ID: ' . $id
            ], 404);
        }
    }
    public function categories()
    {
        return ['data' => Category::all()];
    }

    public function categoryBlogposts($id)
    {
        if ($blogpost = Blogpost::with('author', 'tags', 'category')->where('category_id', $id)->get()) {
            return ['data' => $blogpost];
        } else {
            return response()->json([
                'message' => 'No category found with ID: ' . $id
            ], 404);
        }
    }

    public function addCategory(Request $request)
    {
        $request->validate(['title' => 'required|unique:categories|max:30', '']);
        $category = new Category();
        $category->title = $request->title;
        $category->save();
        return response()->json(['message' => 'The catagory: ' . $request->title . ' has been created'], 201);
    }
    
    public function deleteCategory(Request $request)
    {
        if (!Category::find($request->id)) {
            return response()->json(['message' => 'The category id: ' . $request->id . ' could not be found'], 404);
        } else {
            return Category::destroy($request->id);
        }
    }
}
