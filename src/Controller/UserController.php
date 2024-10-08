<?php

namespace Src\Controller;

use Src\Models\User;
use Src\Request\Request;
use DateTime;

class UserController
{
    public function create(Request $request)
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (strpos($contentType, 'application/json') !== false) {
            $data = json_decode(file_get_contents('php://input'), true);
            $first_name = $data['first_name'] ?? null;
            $last_name = $data['last_name'] ?? null;
            $birthday = $data['birthday'] ?? null;
        } else {
            $first_name = $request->post('first_name') ?? null;
            $last_name = $request->post('last_name') ?? null;
            $birthday = $request->post('birthday') ?? null;
        }
        // TODO for later, make an array for all string attributes and check with foreach if all are strings
        if (empty($first_name)) {
            echo "First name is mandatory.";
            return;
        }
        if (!is_string($first_name)) {
            echo "First name must be a string.";
            return;
        }

        if (empty($last_name)) {
            echo "Last name is mandatory.";
            return;
        }
        if (!is_string($last_name)) {
            echo "Last name must be a string.";
            return;
        }

        if (empty($birthday)) {
            echo "Birthday is mandatory.";
            return;
        }
        if (!DateTime::createFromFormat('Y-m-d', $birthday)) {
            echo "Birthday is in wrong date format.";
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

        if ($user) {
            echo json_encode($user->toArray());
        } else {
            echo "User not found!";
        }

    }

    public function update(string $id, Request $request)
    {
        $user = User::find($id);

        if ($user) {
            $first_name = $request->post("first_name") ?? null;
            $last_name = $request->post("last_name") ?? null;
            $birthday = $request->post("birthday") ?? null;

            if ($first_name !== null && is_string($first_name)) {
                $user->first_name = $first_name;
            }

            if ($last_name !== null && is_string($last_name)) {
                $user->last_name = $last_name;
            }

            if ($birthday !== null) {
                if (!DateTime::createFromFormat('Y-m-d', $birthday)) {
                    echo "Birthday is in wrong date format.";
                    return;
                } else {
                    $user->birthday = $birthday;
                }

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
            $user->delete($id);
        } else {
            echo "Could not delete user, user not found!";
        }

    }

}