<?php

namespace App\Entity;

class UserRole
{
  const ADMIN = "ROLE_ADMIN";
  const USER = "ROLE_USER";

  public static function getAll(bool $includeAdmin = false)
  {
    $roles = [self::USER];

    if ($includeAdmin) {
      $roles[] = self::ADMIN;
    }

    return $roles;
  }
}
