<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Article::class);
  }

  /**
   * Finds top number of articles
   *
   * @param integer $number
   * @return Article[]
   */
  public function findTop(int $number)
  {
    $qb = $this->createQueryBuilder('a')
      ->setMaxResults($number);
    
    return $qb->getQuery()->getResult();
  }
}
