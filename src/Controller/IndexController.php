<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
  /**
   * @Route("/", name="index")
   */
  public function index(ArticleRepository $articleRepository): Response
  {
    // 1 - Je récupère les articles en discutant avec ma couche de service
    $articles = $articleRepository->findAll();
    
    // 2 - Je transmets les articles à la vue que je souhaite afficher
    return $this->render('index/index.html.twig', [
      'articles' => $articles,
    ]);
  }

  /**
   * @Route("/qui-sommes-nous", name="presentation")
   */
  public function presentation(): Response
  {
    return $this->render('index/presentation.html.twig');
  }

  /**
   * @Route("/promo", name="promo")
   */
  public function promo(): Response
  {
    return $this->render('index/promo.html.twig', [
      'mobile_app_name' => 'SuperNewsApp'
    ]);
  }
}
