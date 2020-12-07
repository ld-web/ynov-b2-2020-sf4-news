<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractBaseEntity
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  protected $id;

  public function getId(): ?int
  {
    return $this->id;
  }
}
