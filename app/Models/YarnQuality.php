<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YarnQuality extends Model
{
    protected $fillable = [
        'name',
        'code',
        'construction',
        'read',
        'pick',
        'warp_count',
        'weft_count',
        'width_inches',
        'unit_cost_meter',
        'warp_weight_per_meter_lb',
        'weft_weight_per_meter_lb',
        'total_weight_per_meter_lb',
    ];

    protected $casts = [
        'read' => 'decimal:4',
        'pick' => 'decimal:4',
        'warp_count' => 'decimal:4',
        'weft_count' => 'decimal:4',
        'width_inches' => 'decimal:2',
        'unit_cost_meter' => 'decimal:2',
        'warp_weight_per_meter_lb' => 'decimal:4',
        'weft_weight_per_meter_lb' => 'decimal:4',
        'total_weight_per_meter_lb' => 'decimal:4',
    ];

    public function getDisplayNameAttribute(): string
    {
        $code = $this->code ?: 'YRN-'.str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);

        return $code.' · '.$this->name;
    }
}
