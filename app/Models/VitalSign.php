<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class VitalSign extends Model implements ContractsAuditable
{
    use HasFactory, ModelTrait, Auditable;

    protected $guarded = [];

    public function checkup()
    {
        return $this->belongsTo(Checkup::class,'checkup_id','id');
    }

    public function typeVital()
    {
        return $this->belongsTo(TypeVital::class, 'type_vital_id','id');
    }

    public function getLabelCheckupAttribute()
    {
        return $this->checkup->no;
    }

    public function getLabelVitalAttribute()
    {
        return $this->typeVital->name;
    }
}
