<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Finance extends Model
{

    use HasFactory;
    use AsSource;
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'type', 'description',
    ];
}
