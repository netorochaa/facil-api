<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'cpf',
        'phone',
    ];

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when(
            $search,
            fn (Builder $query) => $query->where('patients.name', 'like', "%$search%")
        );
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
