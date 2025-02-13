<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Fisik;
use App\Models\User;

class FisikPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Fisik');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Fisik $fisik): bool
    {
        //return $user->checkPermissionTo('view Fisik');
        if ($fisik->masyarakat->user_id == $user->id || $user->is_admin) {
            return $user->checkPermissionTo('view Fisik');
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Fisik');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Fisik $fisik): bool

    {
        //return $user->checkPermissionTo('update Fisik');
        if ($fisik->masyarakat->user_id == $user->id || $user->is_admin) {
            return $user->checkPermissionTo('update Fisik');
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Fisik $fisik): bool
    {
        return $user->checkPermissionTo('delete Fisik');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('{{ deleteAnyPermission }}');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Fisik $fisik): bool
    {
        return $user->checkPermissionTo('restore Fisik');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('{{ restoreAnyPermission }}');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Fisik $fisik): bool
    {
        return $user->checkPermissionTo('{{ replicatePermission }}');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('{{ reorderPermission }}');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Fisik $fisik): bool
    {
        return $user->checkPermissionTo('force-delete Fisik');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('{{ forceDeleteAnyPermission }}');
    }
}
