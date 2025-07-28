<?php

namespace App\Models;

use App\Enums\StatusPrecription;
use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class Prescription extends Model implements ContractsAuditable
{
    use HasFactory, ModelTrait, Auditable;

    protected $guarded = [];
    protected $searchField = ['no','searchPatient'];

    public function checkup()
    {
        return $this->belongsTo(Checkup::class, 'checkup_id','id');
    }

    public function prescriptionItems()
    {
        return $this->hasMany(PrescriptionItem::class, 'prescription_id', 'id');
    }


    public function scopeByLikeKode($query, $value)
    {
        if($value) {
            return $query->where('no', 'like', $value);
        }
    }

    protected static function booted()
    {
        static::saved(function ($prescription) {
            $prescription->updateTotal();
        });
    }

    public function updateTotal()
    {
        $total = $this->prescriptionItems()->sum('subtotal');
        $this->updateQuietly(['total' => $total]);
    }

     protected function labelStatus(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                return StatusPrecription::valName($this->status);
            },
        );
    }

     protected function labelCheckup(): Attribute
    {
        return Attribute::make(
            get: fn () => optional($this->checkup)->no
        );
    }
}
