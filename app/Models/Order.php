<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Order extends Model
{
    use HasFactory;
    use AsSource;
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'status',
        'total',
    ];

    /**
     * Get the client that owns the order.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
