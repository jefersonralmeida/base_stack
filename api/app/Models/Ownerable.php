<?php

namespace App\Models;


/**
 * Interface Ownerable
 * @package App\Models
 * @property User $owner
 */
interface Ownerable
{
    public function owner();

    public function ownedBy(User $owner): bool;
}
