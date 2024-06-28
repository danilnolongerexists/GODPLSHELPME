<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Client extends Model
{

    use HasFactory, AsSource;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'notes',
    ];

    /**
     * Get the orders for the client.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
