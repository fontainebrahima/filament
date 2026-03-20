<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name",
        "sku",
        "description",
        "price",
        "stock",
        "image",
        "is_active",
        "is_featured",
    ];

    protected $casts = [
        "is_active" => "boolean",
        "is_featured" => "boolean",
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->sku = IdGenerator::generate([
                'table' => 'products','field' => 'sku','length' => 15,'prefix' => 'PRD-'. date('ymd'),
            ]);
        });
    }
}
