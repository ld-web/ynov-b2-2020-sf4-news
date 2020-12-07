<?php

namespace App\Entity;

use DateTime;

trait DateCreatedTrait
{
  /**
   * @ORM\Column(type="datetime", nullable=true)
   */
  private $dateCreated = new DateTime();

  /**
   * Get the value of dateCreated
   */
  public function getDateCreated(): DateTime
  {
    return $this->dateCreated;
  }

  /**
   * Set the value of dateCreated
   *
   * @return  self
   */
  public function setDateCreated(DateTime $dateCreated)
  {
    $this->dateCreated = $dateCreated;

    return $this;
  }
}
