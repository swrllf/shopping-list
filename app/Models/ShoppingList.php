<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ShoppingList extends Model
{
    // Белый список полей (пункт 6 чек-листа)
    protected $fillable = ['title'];

    // Список принадлежит создателю
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // В списке много товаров
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    // Генерация токена для приглашения
    public static function boot()
    {
        parent::boot();
        static::creating(function ($list) {
            $list->share_token = Str::random(32);
        });
    }
}