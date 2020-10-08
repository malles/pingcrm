<?php

namespace App\Models;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function parcs()
    {
        return $this->hasMany(Parc::class);
    }
}
