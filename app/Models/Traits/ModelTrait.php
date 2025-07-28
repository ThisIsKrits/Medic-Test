<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\AktifEnum;
use App\Models\User;

trait ModelTrait
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeBySearch($query, $value)
    {
        if (!$value) return $query;

        $query->where(function ($q) use ($value) {
            foreach ($this->searchField as $field) {
                if ($this->hasNamedScope($field)) {
                    $q->$field($value);
                } else {
                    $q->orWhere($field, 'like', '%' . $value . '%');
                }
            }
        });

        return $query;
    }

    public function scopeByFilter($query, $value)
    {
        if($value && is_array($value)) {
            foreach($this->filterField as $field) {
                $query  = isset($value[$field]) && $value[$field]
                    ? $query->where($field, $value[$field])
                    : $query;
            }
            return $query;
        }
    }

    public function scopeByFilterRelation($query, $value)
    {
        if($value && is_array($value)) {
            foreach($this->filterRelationField as $relationField) {
                list($relation, $field) = explode(".", $relationField);

                $query  = isset($value[$relationField]) && $value[$relationField]
                    ? $query->whereRelation($relation, $field, 'like', '%'.$value[$relationField].'%')
                    : $query;
            }
            return $query;
        }
    }

    public function scopeOrderField($query, $field, $order = false)
    {
        $order = $order ? $order : 'asc';

        if($field) {
            $fields = explode(".", $field);
            if(count($fields) > 1 ) {
                return $this->hasNamedScope($fields[0])
                    ? $query->orderBy($query->{$fields[0]}($fields[1]), $order)
                    : $query;
            }
            return $query->orderBy($fields[0], $order);
        }

        if(isset($this->searchField)) {
            return $query->orderBy($this->searchField[0], $order);
        }
    }

    public function scopeExclude($query, $value)
    {
        if($value) {
            return is_array($value)
                ? $query->whereNotIn('id', $value)
                : $query->whereNot('id', $value);
        }
    }

    public function scopeByAktif($query, $value)
    {
        if($value) {
            return $query->where('aktif', $value);
        }
    }

    public function scopeByStatus($query, $value)
    {
        if($value) {
            return $query->where('status', $value);
        }
    }

    public function labelUser(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                return $this->user->name;
            },
        );
    }

    public function labelCreated(): Attribute
    {
        return Attribute::make(
            get: function($value) {

                return $this->updated_at
                    ? human_date($this->updated_at, 'DD-MMM-Y HH:mm:s')
                    : human_date($this->created_at, 'DD-MMM-Y HH:mm:s');
            },
        );
    }

    public function labelAktif(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                return AktifEnum::valName($this->aktif);
            },
        );
    }

    public function labelAktifChecklist(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                $route = isset($this->mainRoute)
                    ? $this->mainRoute.'.update'
                    : false;

                return default_status_checkbox($this->aktif, $this->id, $route);
            },
        );
    }

    public function setStatusAktif($value = false)
    {
        $aktif = $this->aktif == AktifEnum::AKTIF
            ? AktifEnum::NONAKTIF
            : AktifEnum::AKTIF;

        if($value) {
            $aktif = AktifEnum::AKTIF;
        }

        $this->aktif = $aktif;
        $this->save();
    }
}
