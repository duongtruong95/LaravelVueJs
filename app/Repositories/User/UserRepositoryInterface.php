<?php
namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function list();
    public function saveToken($request);
}
