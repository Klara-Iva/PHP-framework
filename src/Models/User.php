<?php

namespace Src\Models;

class User extends Model
{
    protected $table = 'users';

    public function create()
    {
        $first_name = $_GET['first_name'] ?? null;
        $last_name = $_GET['last_name'] ?? null;
        $birthday = $_GET['birthday'] ?? null;

        if ($first_name && $last_name) {
            $user = new User();
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            if ($birthday) {
                $user->birthday = $birthday;
            }

            $user->save();
            echo "User created successfully!";
        } else {
            echo "Missing parameters!";
        }

    }

    public function read(string $id)
    {
        $user = User::find($id);

        if ($user) {
            echo json_encode($user->toArray());
        } else {
            echo "User not found!";
        }

    }

    public function update(string $id)
    {
        $this->id = $id;
        $user = User::find($this->id);

        if ($user) {
            $first_name = $_GET['first_name'] ?? null;
            $last_name = $_GET['last_name'] ?? null;
            $birthday = $_GET['birthday'] ?? null;

            if ($first_name !== null) {
                $user->first_name = $first_name;
            }
            if ($last_name !== null) {
                $user->last_name = $last_name;
            }
            if ($birthday !== null) {
                $user->birthday = $birthday;
            }

            $user->save();
            echo "User updated successfully!";
        } else {
            echo "User not found!";
        }

    }

    public function delete(string $id)
    {
        $user = User::find($id);

        if ($user) {
            parent::delete($id);
        } else {
            echo "User not found!";
        }

    }

}