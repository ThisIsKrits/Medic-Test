<?php

namespace App\Repositories;

use App\Models\TypeVital;

class TypeVitalRepository
{

    public function dataIndex($request = false)
    {
        return TypeVital::bySearch($request->search)->paginate(10);
    }

    public function findById($id)
    {
        return TypeVital::findOrFail($id);
    }

    public function modelField()
    {
        return [
            'name'=> [
                'label' => 'Nama',
                'is_show' => '',
                'type' => 'text',
                'required'  => 1
            ],
            'unit'=> [
                'label' => 'Satuan',
                'is_show' => '',
                'type' => 'text',
                'required'  => 1
            ],
        ];
    }

    public function formField()
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
                                ...$modelField['name']
                            ],
                            [
                                'key' => 'unit',
                                ...$modelField['unit']
                            ],

                        ]
                    ],
                ]
            ],
        ];
    }
}
