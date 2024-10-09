<?php

namespace Src\Controller;

use Src\Models\User;
use Src\Request\Request;
use DateTime;

class UserController
{
    public function create(Request $request)
    {
        $first_name = $request->get('first_name') ?? null;
        $last_name = $request->get('last_name') ?? null;
        $birthday = $request->get('birthday') ?? null;

        $data = [
            'first name' => $first_name,
            'last name' => $last_name,
        ];

        foreach ($data as $key => $value) {
            if (empty($value) || !is_string($value)) {
                echo ucfirst($key) . " is mandatory and must be a valid string.";
                return;
            }
        }

        if (empty($birthday)) {
            echo "Birthday is mandatory.";
            return;
        }

        if (!DateTime::createFromFormat('Y-m-d', $birthday)) {
            echo "Birthday is in wrong date format, right format is YYYY-MM-DD.";
            return;
        }

        $user = new User();
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->birthday = $birthday;
        $user->save();
        echo "User created successfully!";
    }

    public function read(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            echo "User not found!";
            return;
        }

        echo json_encode($user->toArray());
    }

    public function update(string $id, Request $request)
    {
        if (!$id) {
            echo "ID is required!";
            return;
        }

        $user = User::find($id);

        if (!$user) {
            echo "User not found!";
            return;
        }

        $first_name = $request->get("first_name") ?? $user->first_name;
        $last_name = $request->get("last_name") ?? $user->last_name;
        $birthday = $request->get("birthday") ?? $user->birthday;

        if (empty($first_name) || !is_string($first_name)) {
            echo "First name is mandatory and must be a valid string.";
            return;
        }

        if (empty($last_name) || !is_string($last_name)) {
            echo "Last name is mandatory and must be a valid string.";
            return;
        }

        $user->first_name = $first_name;
        $user->last_name = $last_name;

        if ($birthday !== null) {
            if (!DateTime::createFromFormat('Y-m-d', $birthday)) {
                echo "Birthday is in wrong date format, requested format is YYYY-MM-DD.";
                return;
            }
            $user->birthday = $birthday;
        }

        $user->save();
        echo "User updated successfully!";
    }

    public function delete(string $id)
    {
        if (!$id) {
            echo "ID is required!";
            return;
        }

        $user = User::find($id);

        if (!$user) {
            echo "Could not delete user, user not found!";
            return;
        }

        $user->delete($id);

    }

}