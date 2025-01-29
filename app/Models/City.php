<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'state',
    ];

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when(
            $search,
            fn (Builder $query) => $query->where('name', 'like', "%$search%")
        );
    }
}
