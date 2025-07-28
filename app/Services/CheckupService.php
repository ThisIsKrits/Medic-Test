<?php

namespace App\Services;

use App\Models\Checkup;
use App\Models\CheckupFile;
use App\Models\VitalSign;
use Illuminate\Support\Facades\Auth;

class CheckupService
{
    public $model = Checkup::class;

    public function store($data)
    {
        return Checkup::create($data);
    }

    public function storeDetail($data)
    {
        return VitalSign::create($data);
    }

    public function storeFile($data)
    {
        return CheckupFile::create($data);
    }

    public function update(Checkup $item, $data)
    {
        $item->fill($data)->save();

        return $item;
    }

    public function updateDetail(VitalSign $item, $data)
    {
        $item->fill($data)->save();

        return $item;
    }

    public function updateFile(CheckupFile $item, $data)
    {
        $item->fill($data)->save();

        return $item;
    }

    public function destroy(Checkup $item)
    {
        $item->checkupFile()->delete();
        $item->vitalSign()->delete();
        $item->delete();
    }

    public function setData($request):array
    {
        return [
            'patient_id' => $request['patient_id'],
            'no'         => $request['no'],
            'tgl'        => $request['tgl'],
            'user_id'    => Auth::user()->id,
            'note'       => $request['note'],
        ];
    }

    public function setDataDetail($request, $index):array
    {
        return [
            'type_vital_id' => $request['type_vital_id'][$index],
            'value'         => $request['value'][$index],
        ];
    }

    public static function setDataFile($request, $index)
    {
        return [
            'document' => isset($request->file['document'][$index]) ? $request->file['document'][$index] : null,
        ];
    }

    public static function lastCode()
    {
        $item = Checkup::byLikeKode('C%')
            ->orderBy('no', 'desc')
            ->first();

        if(!$item) {
            return 'C000001';
        }
        return 'C'.sprintf('%06d', (substr($item->no, 3) +1));
    }

    public function saveDataDetail(Checkup $item, $request, $children = false)
    {
        $detail = $request['detail'];

        foreach ($detail['type_vital_id'] as $index => $checkupId) {
            $detailData = $this->setDataDetail($detail, $index);
            $detailData['checkup_id'] = $item->id;

            // store to detail
            $storeDetail = isset($detail['id'][$index])
                ? $this->updateDetail($children[$detail['id'][$index]], $detailData)
                : $this->storeDetail($detailData);

        }
    }

   public function saveDataDocument(Checkup $item, $request, $children = false)
    {
        $documents = $request['file']['document'] ?? [];
        $files = request()->file('file.document') ?? [];
        $path = 'storage/document';

        create_dir($path);

        foreach ($documents as $index => $val) {
            $file = $files[$index] ?? null;

            if ($file && $file->isValid()) {
                $type = $file->getClientOriginalExtension();
                $filename = 'document_' . random_int(1, 99) . '_' . now()->format('Ymd_His') . '.' . $type;

                $filepath = $type === 'pdf'
                    ? save_pdf($file, $path, $filename)
                    : save_image($file, $path, $filename);

                $data = ['document' => $filepath];

                $documentId = $request['document_id'][$index] ?? null;

                if ($documentId && isset($children[$documentId])) {
                    $children[$documentId]->update($data);
                } else {
                    $item->checkupFile()->create($data);
                }
            }
        }
    }





}
