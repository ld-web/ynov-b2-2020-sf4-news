<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use App\Entity\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
  private $encoder;

  public function __construct(UserPasswordEncoderInterface $encoder)
  {
    $this->encoder = $encoder;
  }

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

    $user = new User();
    $user->setEmail('lucas@ld-web.net')
      ->setRoles([UserRole::ADMIN]);

    $user->setPassword($this->encoder->encodePassword(
      $user,
      'blablabla'
    ));
    $manager->persist($user);

    $user = new User();
    $user->setEmail('test@test.com');
    $user->setPassword($this->encoder->encodePassword(
      $user,
      'blablabla'
    ));

    $manager->persist($user);

    $manager->flush();
  }
}
