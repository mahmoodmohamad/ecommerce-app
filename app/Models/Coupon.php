<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'type', 'value', 'expires_at'];

    public function isValid()
    {
        return $this->expires_at >= now();
    }

    public function applyDiscount($amount)
    {
        return $this->type === 'fixed'
            ? max(0, $amount - $this->value)
            : max(0, $amount * (1 - $this->value / 100));
    }
}
