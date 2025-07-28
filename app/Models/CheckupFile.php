<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class CheckupFile extends Model implements ContractsAuditable
{
    use HasFactory, Auditable;
    protected $guarded = [];

    public function checkup()
    {
        return $this->belongsTo(Checkup::class, 'checkup_id','id');
    }


    public function getLabelDocumentAttribute($value) {
        if ($this->document) {
            if($this->type == 'pdf') {
                return '<a
                    href=" '.asset('storage/document/' . $this->document).' "
                    class="btn btn-sm btn-link mb-1 py-0"
                    target="_blank">
                    <h1><i class="fa-regular fa-file-pdf text-danger"></i></h1>
                </a>';
            }

            return '<a
                        href=" '.asset('storage/document/' . $this->document).' "
                        class="py-0"
                        target="_blank">
                        <img src="'.Storage::url('document/' . $this->document).'" width="25%" alt="Payment Proof" >
                    </a>';
        }

        return '';
    }
}
