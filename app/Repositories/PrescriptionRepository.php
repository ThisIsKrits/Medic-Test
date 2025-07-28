<?php

namespace App\Repositories;

use App\Models\Prescription;
use App\Services\PrescriptionService;
use App\Services\PrescriptionServiceService;

class PrescriptionRepository
{

    public function dataIndex($request = false)
    {
        return Prescription::bySearch($request->search)->paginate(10);
    }

    public function findById($id)
    {
        return Prescription::findOrFail($id);
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
            'label_checkup'=> [
                'label' => 'Nomer Pemeriksaan',
                'is_show' => '',
                'type' => 'select',
                'required'  => 1
            ],
            'label_status'=> [
                'label' => 'Status Resep',
                'is_show' => '',
                'type' => 'select',
                'required'  => 1
            ],
            'total'=> [
                'label' => 'Total',
                'is_show' => '',
                'type' => 'number',
                'required'  => 1
            ],
        ];
    }

    public function modelDetailField()
    {
        return [
            'medicine'=> [
                'label' => 'Nama Obat',
                'is_show' => '',
                'type' => 'select',
                'required' => 1,
            ],
            'qty'=> [
                'label' => 'Qty',
                'is_show' => '',
                'type' => 'number',
                'col_class' => 'text-end',
                'required' => 1
            ],
            'price'=> [
                'label' => 'Price',
                'is_show' => '',
                'type' => 'number',
                'col_class' => 'text-end',
                'required' => 1
            ],
            'subtotal'=> [
                'label' => 'Subtotal',
                'is_show' => '',
                'type' => 'number',
                'col_class' => 'text-end',
                'required' => 1
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
                                'key' => 'no',
                                'default_value' => PrescriptionService::lastCode(),
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
                                'key' => 'checkup_id',
                                'options' => checkup(),
                                ...$modelField['label_checkup']
                            ],

                        ]
                    ],
                ]
            ],
        ];
    }
}
