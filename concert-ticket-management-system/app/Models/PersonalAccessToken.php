<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalAccessToken extends Model
{

    protected $fillable = ["token", "expires_at"];
    protected $hidden = ["token"];

    public function User() {
        return $this->hasOne(User::class);
    }
}
