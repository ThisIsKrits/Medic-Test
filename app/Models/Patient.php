<?php

namespace App\Models;

use App\Enums\AktifEnum;
use App\Enums\GenderEnum;
use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class Patient extends Model implements ContractsAuditable
{
    use HasFactory, Auditable, ModelTrait;

    protected $guarded = [];
    protected $searchField = ['name'];

    protected function labelStatus(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                return AktifEnum::valName($this->status);
            },
        );
    }

    protected function labelGender(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                return GenderEnum::valName($this->gender);
            },
        );
    }
}
