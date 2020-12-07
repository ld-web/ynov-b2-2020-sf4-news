<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
  public const NB_HOME = 12;

  use IdTrait;
  use DateCreatedTrait;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $title;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $cover;

  /**
   * @ORM\Column(type="text")
   */
  private $content;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $subtitle;

  /**
   * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="articles")
   */
  private $categories;

  public function __construct()
  {
    $this->categories = new ArrayCollection();
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(string $title): self
  {
    $this->title = $title;

    return $this;
  }

  public function getCover(): ?string
  {
    return $this->cover;
  }

  public function setCover(string $cover): self
  {
    $this->cover = $cover;

    return $this;
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function setContent(string $content): self
  {
    $this->content = $content;

    return $this;
  }

  public function getSubtitle(): ?string
  {
    return $this->subtitle;
  }

  public function setSubtitle(?string $subtitle): self
  {
    $this->subtitle = $subtitle;

    return $this;
  }

  /**
   * @return Collection|Category[]
   */
  public function getCategories(): Collection
  {
    return $this->categories;
  }

  public function addCategory(Category $category): self
  {
    if (!$this->categories->contains($category)) {
      $this->categories[] = $category;
      $category->addArticle($this);
    }

    return $this;
  }

  public function removeCategory(Category $category): self
  {
    if ($this->categories->removeElement($category)) {
      $category->removeArticle($this);
    }

    return $this;
  }
}
