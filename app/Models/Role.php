<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected static function booted()
    {
        // Auto exclude super_admin from ALL queries (index/listing)
        // static::addGlobalScope('excludeSuperAdmin', function (Builder $query) {
        //     $query->where('name', '!=', 'super_admin');
        // });
        

        // Prevent CREATE super_admin
        static::creating(function ($role) {
            if ($role->name === 'super_admin') {
                abort(403, 'You cannot create a role with the name super_admin.');
            }
        });

        // Prevent UPDATE on super_admin
        static::updating(function ($role) {
            if ($role->getOriginal('name') === 'super_admin') {
                abort(403, 'You cannot edit the super_admin role.');
            }
        });

        // Prevent DELETE on super_admin
        static::deleting(function ($role) {
            if ($role->name === 'super_admin') {
                abort(403, 'You cannot delete the super_admin role.');
            }
        });
    }
}
