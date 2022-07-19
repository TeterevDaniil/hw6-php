<?php

namespace App\Model\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Model\Eloquent
 * 
 * @property $id
 * @property $name
 * @property $email
 * @property $password
 */

class User extends Model
{
    protected $table = 'clients';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'password',
    ];

    public static function getById(int $id): ?self
    {
        return self::query()->where('id', '=', $id)->first();
    }

    public static function getList(int $limit = 10, int $offset = 0)
    {
        return self::query()->limit($limit)->offset($offset)->orderBy('id', 'DESC')->get();
    }

    public static function getNameById(int $id)
    {
        return self::query()->where('id', '=', $id)->first();
    }

    public static function getByName(string $name)
    {
        return self::query()->where('name', '=', $name)->first();
    }

    public static function getByEmail(string $email)
    {
        return self::query()->where('email', '=', $email)->first();
    }


    public function getName(): string
    {
        return $this->name;
    }
  
    public function getId(): int
    {
        return $this->id;
    }
   
    public function getPassword(): string
    {
        return $this->password;
    }
  
    public function getEmail(): string
    {
        return $this->email;
    }
 
    public function getInsertDate(): string
    {
        return $this->insert_date;
    }
  
    public function isAdmin(): bool
    {
        return in_array($this->id, ADMIN_IDS);
    }
}
