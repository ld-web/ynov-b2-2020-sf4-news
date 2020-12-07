<?php

namespace App\Entity;

trait IdTrait
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
