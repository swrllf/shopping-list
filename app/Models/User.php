<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
        // Связь: у пользователя много списков
    public function shoppingLists(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShoppingList::class);
    }
        /**
     * Проверяет, является ли пользователь администратором
     */
    
    public function isAdmin(): bool
    {
        // Если в сессии включен режим "как пользователь" - возвращаем false
        if (session()->has('view_as_user')) {
            return false;
        }
        return $this->role === 'admin';
    }

// Новый метод: проверяет реальную роль, игнорируя сессию (для переключения)
    public function isRealAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
