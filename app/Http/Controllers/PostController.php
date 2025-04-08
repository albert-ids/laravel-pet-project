<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="RSS Parser API",
 *     version="1.0",
 *     description="Документація API для керування постами"
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Локальний сервер"
 * )
 */

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Список постів",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Пошук за заголовком",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Сортувати за полем (title, pub_date)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="order",
     *         in="query",
     *         description="Напрям сортування (asc, desc)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успішна відповідь"
     *     )
     * )
     */

    public function index(Request $request)
    {
        $query = Post::query();

        // filtering by name
        if($request->has('search')){
            $query->where('title', 'like', '%'. $request->search . '%');
        }

        // sorting
        if($request->has('sort_by') && $request->has('order')){
            $query->orderBy($request->sort_by, $request->order);
        }

        //pagination
        $perPage = $request->get('per_page', 10);

        return response()->json($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage..
     * POST /api/posts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Створити новий пост",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "link"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="link", type="string", format="url"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="pub_date", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Пост створено"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Помилка валідації"
     *     )
     * )
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'link'  => 'required|url|unique:posts',
            'description' => 'nullable|string',
            'pub_date' => 'nullable|date',
        ]);

        $post = Post::create($validated);

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     * GET /api/posts/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Отримати пост по ID",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID поста",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успішна відповідь"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Пост не знайдено"
     *     )
     * )
     */

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/posts/{id}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Оновити пост",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID поста",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "link"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="link", type="string", format="url"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="pub_date", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Пост оновлено"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Пост не знайдено"
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title'=> 'required|string',
            'link' => 'requires|url|unique:posts,link,' . $post->id,
            'description' => 'nullable|string',
            'pub_date' => 'nullable|date',
        ]);

        $post->update($validated);

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/posts/{id}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Видалити пост",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID поста",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Пост видалено"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Пост не знайдено"
     *     )
     * )
     */

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete;

        return response()->json(['message'=>'Post deleted']);
    }
}
