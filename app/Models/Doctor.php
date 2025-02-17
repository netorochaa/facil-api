<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    /** @use HasFactory<\Database\Factories\DoctorFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['name', 'specialty', 'city_id'];

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when(
            $search,
            fn (Builder $query) => $query->where('name', 'like', "%$search%")
        );
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
