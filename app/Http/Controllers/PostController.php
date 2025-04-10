<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostRepositoryInterface;
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
    protected $postRepo;

    public function __construct(PostRepositoryInterface $postRepo){
        $this->postRepo = $postRepo;
    }

    public function index(Request $request){
        $filters = $request->only(['search', 'sort_by', 'order']);
        $perPage = $request->get('per_page', 10);

        $post = $this->postRepo->getAllPosts($filters, $perPage);

        return PostResource::collection($post);
    }

    public function store(Request $request){
        $post = $this->postRepo->createPost($request->validated());

        return (new PostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    public function show($id){
        $post = $this->postRepo->findPostById($id);

        return new PostResource($post);
    }

    public function update(Request $request, $id){
        $post = $this->postRepo->updatePost($id, $request->validated());

        return new PostResource($post);
    }

    public function destroy($id){
        $this->postRepo->deletePost($id);

        return response()->json(['message' => 'post Deleted']);
    }
}
