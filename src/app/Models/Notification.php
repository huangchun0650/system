<?php

namespace YFDev\System\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const FIELDS = [
        'customer_id',
        'model_type',
        'model_id',
        'event',
        'message',
        'isRead',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
