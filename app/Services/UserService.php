<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserService
{
    public function store($data)
    {
        if (isset($data['role_id'])) {
            $roleName = Role::find($data['role_id'])?->name;
            unset($data['role_id']);
        }

        $user = User::create($data);

        if (!empty($roleName)) {
            $user->assignRole($roleName);
        }

        return $user;
    }

    public function update(User $item, $data)
    {
        if (isset($data['role_id'])) {
            $roleName = Role::find($data['role_id'])?->name;
            unset($data['role_id']);
        }

        $item->fill($data)->save();

        if (!empty($roleName)) {
            $item->syncRoles([$roleName]);
        }

        return $item;
    }

    public function destroy(User $item)
    {
        $item->delete();
    }

    public function setData($request):array
    {
        $data = [
            'name' => $request['name'],
            'email' => $request['email'],
            'role_id' => $request['role_id'],
        ];

        if(isset($request['password'])) {
            $data['password'] = bcrypt($request['password']);
        }

        return $data;
    }
}
