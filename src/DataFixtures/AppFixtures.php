<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    $faker = Faker\Factory::create();

    for ($i = 0; $i < 25; $i++) {
      $article = new Article();
      $article
        ->setTitle($faker->sentence(7))
        ->setSubtitle($faker->text(70))
        ->setCover($faker->imageUrl())
        ->setContent($faker->paragraph(24));
      $manager->persist($article);
    }

    $manager->flush();
  }
}
