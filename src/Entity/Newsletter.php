<?php

namespace App\Entity;

use App\Repository\NewsletterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NewsletterRepository::class)
 */
class Newsletter
{
  use IdTrait;
  
  /**
   * @ORM\Column(type="string", length=255)
   * @Assert\Email()
   */
  private $email;

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;

    return $this;
  }
}
