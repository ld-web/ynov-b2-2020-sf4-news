<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    $article = new Article();
    $article
      ->setTitle('Mon article de test')
      ->setSubtitle('Mon sous-titre d\'article')
      ->setCover('img.jpg')
      ->setContent('Blablabla')
    ;

    $manager->persist($article);
    $manager->flush();
  }
}
