<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
  /**
   * @Route("/", name="index")
   */
  public function index(Request $request, ArticleRepository $articleRepository, EntityManagerInterface $em): Response
  {
    $newsletter = new Newsletter();
    $form = $this->createForm(NewsletterType::class, $newsletter);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($newsletter);
      $em->flush();
    }
    
    // 1 - Je récupère les articles en discutant avec ma couche de service
    $articles = $articleRepository->findTop(Article::NB_HOME);
    
    // 2 - Je transmets les articles à la vue que je souhaite afficher
    return $this->render('index/index.html.twig', [
      'articles' => $articles,
      'newsletterForm' => $form->createView()
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
