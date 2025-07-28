<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class TypeVital extends Model implements ContractsAuditable
{
    use HasFactory, ModelTrait, Auditable;
    protected $guarded = [];
    protected $searchField = ['name'];

}
