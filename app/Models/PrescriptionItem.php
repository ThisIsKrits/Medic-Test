<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class PrescriptionItem extends Model implements ContractsAuditable
{
    use HasFactory, ModelTrait, Auditable;

    protected $guarded = [];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class,'prescription_id','id');
    }

    protected static function booted()
    {
        static::created(function ($item) {
            $item->prescription->updateTotal();
        });

        static::updated(function ($item) {
            $item->prescription->updateTotal();
        });

        static::deleted(function ($item) {
            $item->prescription->updateTotal();
        });
    }

}
