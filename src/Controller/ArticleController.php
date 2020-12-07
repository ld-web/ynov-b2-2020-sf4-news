<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
  /**
   * @Route("/blog/{id}", name="article")
   */
  public function index(Article $article): Response
  {
    return $this->render('article/index.html.twig', [
      'controller_name' => 'ArticleController',
      'article' => $article
    ]);
  }

  /**
   * @Route("/blog/article/new", name="article_new", methods={"GET","POST"})
   */
  public function new(Request $request, EntityManagerInterface $em): Response
  {
    $article = new Article();
    $form = $this->createForm(ArticleType::class, $article);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      /** @var UploadedFile */
      $file = $form->get('coverFile')->getData();

      $filename = md5(uniqid()) . '.' . $file->guessExtension();
      $file->move(
        $this->getParameter('upload_dir'),
        $filename
      );

      $article->setCover($filename);

      $em->persist($article);
      $em->flush();
    }

    return $this->render(
      'article/new.html.twig',
      [
        'form' => $form->createView()
      ]
    );
  }
}
