<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    public function handleUsersRelation($payload, User $user){
        if(isset($payload['users'])){
            switch ($user->role){
                case User::ROLES['pseudo_admin']:
                    $users = collect($payload['users']);
                    $users->reject(function ($id) use ($user){
                        return $id === $user->id;
                    });
                    $user->users()->sync($users);
            }
        }
    }

    public function handlePagesRelation($payload, User $user){
        if(isset($payload['pages'])){
            if($user->role === User::ROLES['pseudo_admin']){
                $user->pages()->sync($payload['pages']);
            }
        }
    }

    public function handleNewPassword(&$payload){
        if($payload['password']){
            $payload['password'] = \Hash::make($payload['password']);
        } else{
            unset($payload['password']);
        }
    }

}
