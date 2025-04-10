<?php

namespace App\Repositories;

interface PostRepositoryInterface{
    public function getAllPosts($filters = [], $perPage = 10);
    public function findPost($id);
    public function createPost(array $data);
    public function updatePost($id, array $data);
    public function deletePost($id);
}