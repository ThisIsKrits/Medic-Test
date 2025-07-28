<?php

namespace App\Repositories;

use App\Models\Checkup;
use App\Services\CheckupService;

class CheckupRepository
{

    public function dataIndex($request = false)
    {
        return Checkup::bySearch($request->search)->paginate(10);
    }

    public function findById($id)
    {
        return Checkup::with('checkupFile')->findOrFail($id);
    }

    public function modelField()
    {
        return [
            'no'=> [
                'label' => 'Nomer',
                'is_show' => '',
                'type' => 'text',
                'required'  => 1
            ],
            'tgl'=> [
                'label' => 'Tanggal',
                'is_show' => '',
                'type' => 'date',
                'required'  => 1
            ],
            'label_patient'=> [
                'label' => 'Nama Pasien',
                'is_show' => '',
                'type' => 'select',
                'required'  => 1
            ],
            'note'=> [
                'label' => 'Note',
                'is_show' => 'd-none',
                'type' => 'text-area',
                'required'  => 0
            ]
        ];
    }

    public function modelDetailField()
    {
        return [
            'label_vital'=> [
                'label' => 'Tanda Vital',
                'is_show' => '',
                'type' => 'select',
                'required' => 1,
            ],
            'value'=> [
                'label' => 'Qty',
                'is_show' => '',
                'type' => 'number',
                'col_class' => 'text-end',
                'required' => 1
            ],
        ];
    }

    public function modelDocumentField()
    {
        return [
            'label_document' => [
                'label' => 'Document',
                'is_show' => '',
                'col_class'=>'text-start',
                'type' => 'text',
                'required'  => 0
            ]
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
                                'key' => 'no',
                                'default_value' => CheckupService::lastCode(),
                                ...$modelField['no']
                            ],
                            [
                                'key' => 'tgl',
                                'default_value' => date('Y-m-d'),
                                ...$modelField['tgl']
                            ],

                        ]
                    ],
                    [
                        'class' => 'row',
                        'fields' => [
                            [
                                'key' => 'patient_id',
                                'options'  => patients(),
                                ...$modelField['label_patient']
                            ],
                            [
                                'key' => 'note',
                                ...$modelField['note']
                            ],

                        ]
                    ],
                ]
            ],
        ];
    }
}
