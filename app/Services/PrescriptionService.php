<?php

namespace App\Services;

use App\Enums\StatusPrecription;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Support\Facades\Auth;

class PrescriptionService
{
    public $model = Prescription::class;

    public function store($data)
    {
        return Prescription::create($data);
    }

    public function storeDetail($data)
    {
        return PrescriptionItem::create($data);
    }

    public function update(Prescription $item, $data)
    {
        $item->fill($data)->save();

        return $item;
    }

    public function updateDetail(PrescriptionItem $item, $data)
    {
        $item->fill($data)->save();

        return $item;
    }

    public function updateStatus(Prescription $item, $status)
    {
        $item->update([
            'status' => $status,
        ]);

        return $item;
    }


    public function destroy(Prescription $item)
    {
        $item->PrescriptionItem()->delete();
        $item->delete();
    }

    public function setData($request):array
    {
        return [
            'checkup_id' => $request['checkup_id'],
            'status'     => 1,
            'no'         => $request['no'],
            'tgl'        => $request['tgl'],
            'total'      => 0,
            'user_id'    => Auth::user()->id,
        ];
    }

    public function setDataDetail($request, $index):array
    {
        return [
            'medicine' => $request['medicine'][$index],
            'qty'      => $request['qty'][$index],
            'price'    => $request['price'][$index],
            'subtotal' => $request['subtotal'][$index],
        ];
    }

    public static function lastCode()
    {
        $item = Prescription::byLikeKode('R%')
            ->orderBy('no', 'desc')
            ->first();

        if(!$item) {
            return 'R000001';
        }
        return 'R'.sprintf('%06d', (substr($item->no, 3) +1));
    }

    public function saveDataDetail(Prescription $item, $request, $children = false)
    {
        $detail = $request['detail'];

        foreach ($detail['medicine'] as $index => $checkupId) {
            $detailData = $this->setDataDetail($detail, $index);
            $detailData['prescription_id'] = $item->id;

            // store to detail
            $storeDetail = isset($detail['id'][$index])
                ? $this->updateDetail($children[$detail['id'][$index]], $detailData)
                : $this->storeDetail($detailData);

        }
    }

}
