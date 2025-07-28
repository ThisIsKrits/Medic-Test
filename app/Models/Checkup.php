<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class Checkup extends Model implements ContractsAuditable
{
    use HasFactory, ModelTrait, Auditable;

    protected $guarded = [];
    protected $searchField = ['no','searchPatient'];

    public function patients()
    {
        return $this->belongsTo(Patient::class, 'patient_id','id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function vitalSign()
    {
        return $this->hasMany(VitalSign::class,'checkup_id','id');
    }

    public function checkupFile()
    {
        return $this->hasMany(CheckupFile::class,'checkup_id','id');
    }

    public function scopeByDoctor($query)
    {
        $user = auth()->user();

        if ($user->hasRole('dokter') && $user->doctor) {
            return $query->where('user_id', $user->doctor->id);
        }

        return $query;
    }


    public function scopeByLikeKode($query, $value)
    {
        if($value) {
            return $query->where('no', 'like', $value);
        }
    }

    public function getLabelPatientAttribute()
    {
        return $this->patients->name;
    }

    protected function labelDoctor(): Attribute
    {
        return Attribute::make(
            get: fn () => optional($this->doctor)->name
        );
    }

    public function getLinkShowAttribute()
    {
        return route('checkup.show', $this);
    }

    public function scopeSearchPatient($query, $value)
    {
        return $query->orWhereHas('patients', function ($q) use ($value) {
            $q->where('name', 'like', '%' . $value . '%');
        });
    }
}
