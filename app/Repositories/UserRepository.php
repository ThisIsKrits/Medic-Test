<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    public function dataIndex($request = false)
    {
        return User::bySearch($request->search)
                ->notSuperAdmin('true')
                ->paginate(10);
    }

    public function findById($id)
    {
        return User::with('roles')->findOrFail($id);
    }

    public function modelField()
    {
        return [
            'name'=> [
                'label' => 'Nama',
                'is_show' => '',
                'type' => 'text',
                'required' => 1
            ],
            'email'=> [
                'label' => 'Email',
                'is_show' => '',
                'type' => 'text',
                'required' => 1
            ],
            'label_role'=> [
                'label' => 'Role',
                'is_show' => '',
                'type' => 'select',
                'required' => 1
            ],
        ];
    }

    public function formField($model = null)
    {
        $modelField = $this->modelField();

        return [
            [
                'class' => 'col-12',
                'fields' => [
                    [
                        'class' => 'row',
                        'fields' => [
                            [
                                'key' => 'name',
                                'class' => 'col-12 col-md-6 col-lg-6',
                                ...$modelField['name']
                            ],
                            [
                                'key' => 'email',
                                'class' => 'col-12 col-md-3 col-lg-3',
                                ...$modelField['email']
                            ],
                            [
                                'key' => 'role_id',
                                'class' => 'col-12 col-md-3 col-lg-3',
                                'options' => roles(),
                                'value' => optional($model?->roles->first())->id,
                                ...$modelField['label_role']
                            ],
                        ]
                    ],
                    [
                        'class' => 'row',
                        'fields' => [
                            [
                                'key' => 'password',
                                'label' => 'Password',
                                'type' => 'password',
                                'required' => $model ? 0 : 1
                            ],
                            [
                                'key' => 'password_confirmation',
                                'label' => 'Confirm Password',
                                'type' => 'password',
                                'required' => $model ? 0 : 1
                            ],
                        ]
                    ],
                ]
            ],
        ];
    }
}
