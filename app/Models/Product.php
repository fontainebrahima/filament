<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[ObservedBy(ProductObserver::class)]
class Product extends Model
{
    use HasFactory, Notifiable;
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
