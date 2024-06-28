<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Models\Role as OrchidRole;
use Orchid\Screen\AsSource;

class Role extends OrchidRole
{

    use HasFactory;
    use AsSource;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug',
    ];

}
