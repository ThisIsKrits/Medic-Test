<?php

namespace App\Services;

use App\Models\Patient;

class PatientService
{
    public $model = Patient::class;

    public function store($data)
    {
        return Patient::create($data);
    }

    public function update(Patient $item, $data)
    {
        $item->fill($data)->save();

        return $item;
    }

    public function destroy(Patient $item)
    {
        $item->delete();
    }

    public function setData($request):array
    {
        return [
            'name'      => $request['name'],
            'gender'    => $request['gender'],
            'birthdate' => $request['birthdate'],
            'phone'     => $request['phone'],
            'address'   => $request['address'],
            'status'    => $request['status'],
        ];
    }
}
