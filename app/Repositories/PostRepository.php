<?php

namespace App\Repositories;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface{
    public function getAllPosts($filters = [], $perPage = 10){
        $query = Post::query();

        if (isset($filters['search'])){
            $query->where('title','like','%'. $filters['search'] . '%');
        }

        if(isset($filters['sort_by']) && isset($filters['order'])){
            $query->orderBy($filters['sort_by'], $filters['order']);
        }

        return $query->paginate($perPage);
    }

    public function findPost($id){
        return Post::findOrFail($id);
    }

    public function createPost(array $data){
        return Post::create($data);
    }

    public function updatePost($id, array $data){
        $post = Post::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function deletePost($id){
        $post = Post::findOrFail($id);
        $post->delete();
        return $post;
    }

}