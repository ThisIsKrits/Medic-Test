<?php

namespace App\Services;

use App\Models\TypeVital;

class TypeVitalService
{
    public $model = TypeVital::class;

    public function store($data)
    {
        return TypeVital::create($data);
    }

    public function update(TypeVital $item, $data)
    {
        $item->fill($data)->save();

        return $item;
    }

    public function destroy(TypeVital $item)
    {
        $item->delete();
    }

    public function setData($request):array
    {
        return [
            'name' => $request['name'],
            'unit' => $request['unit'],
        ];
    }
}
