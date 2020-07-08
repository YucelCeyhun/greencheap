<?php

namespace GreenCheap\User\Model;

use GreenCheap\Database\ORM\ModelTrait;

trait RoleModelTrait
{
    use ModelTrait;

    /**
     * @Saving
     */
    public static function saving($event, Role $role)
    {
        if (!$role->id) {
            $role->priority = self::getConnection()->fetchColumn('SELECT MAX(priority) + 1 FROM @system_role');
        }
    }
}
