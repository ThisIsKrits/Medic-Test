<?php

namespace App\Repositories;

use App\Enums\AktifEnum;
use App\Enums\GenderEnum;
use App\Models\Patient;

class PatientRepository
{

    public function dataIndex($request = false)
    {
        return Patient::bySearch($request->search)->paginate(10);
    }

    public function findById($id)
    {
        return Patient::findOrFail($id);
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
            'birthdate'=> [
                'label' => 'Tanggal Lahir',
                'is_show' => '',
                'type' => 'date',
                'required'  => 1
            ],
            'label_gender'=> [
                'label' => 'Jenis Kelamin',
                'is_show' => '',
                'type' => 'select',
                'required'  => 1
            ],
            'phone'=> [
                'label' => 'No. Telpon',
                'is_show' => '',
                'type' => 'tel',
                'required'  => 1
            ],
            'address'=> [
                'label' => 'Alamat',
                'is_show' => '',
                'type' => 'text-area',
                'required'  => 1
            ],
            'label_status'=> [
                'label' => 'Status',
                'is_show' => '',
                'type' => 'select',
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
                                'key' => 'birthdate',
                                ...$modelField['birthdate']
                            ],

                        ]
                    ],
                    [
                        'class' => 'row',
                        'fields' => [
                            [
                                'key' => 'gender',
                                'options'=> GenderEnum::all(),
                                ...$modelField['label_gender']
                            ],
                            [
                                'key' => 'phone',
                                ...$modelField['phone']
                            ],

                        ]
                    ],
                    [
                        'class' => 'row',
                        'fields' => [
                            [
                                'key' => 'address',
                                ...$modelField['address']
                            ],
                            [
                                'key' => 'status',
                                'options' => AktifEnum::all(),
                                ...$modelField['label_status']
                            ],

                        ]
                    ],
                ]
            ],
        ];
    }
}
