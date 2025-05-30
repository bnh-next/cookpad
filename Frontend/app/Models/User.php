<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Các thuộc tính cho phép gán hàng loạt (mass assignable)
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'uuid',
        'is_active',
        'is_superuser',
    ];

    /**
     * Các thuộc tính sẽ bị ẩn khi trả về JSON
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Các kiểu dữ liệu cần ép kiểu
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'is_superuser' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Đảm bảo sử dụng mật khẩu đúng với Laravel Auth
     */
    public function getAuthPassword()
    {
        return $this->password;
    }
}
