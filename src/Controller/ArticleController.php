<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    //Route qui me permet de créer un nouvel article
    #[Route('/article/new', name: 'app_article_new')]
    public function new(EntityManagerInterface $entityManager) : Response
    {

        $article = new Article;
        $article->setTitre('lala');
        $article->setContenu('mon joli contenu');
        $article->setDateCreation(new \DateTime('2017-03-23'));
        $entityManager->persist($article);
        $entityManager->flush();

        return $this->render('article/new.html.twig', [
            'article' => $article,
        ]);

    }
    
    //Route qui mène au tableau avec tous mes articles
    #[Route('/article/liste', name: 'app_article_liste')]
    public function liste(EntityManagerInterface $entityManager): Response
    {
        //
        $repository = $entityManager->getRepository(Article::class);
        //ici $repository devient un objet articleRepository
        $article = $repository->findAll();
        

        return $this->render('article/liste.html.twig', [
            'article' => $article,
        ]);

    }

    /*
    //route qui mène au détail d'un article
    #[Route('/article/vue/{id}', name: 'app_article_detail')]
    public function showByPk(Article $article): Response
    {
        
        return $this->render('article/detail.html.twig', [
            'article' => $article,
            // dans mon twig on peut toujours utiliser article.id(.titre,.contenu, etc)
        ]);

    }
    */
    
    #[Route('/article/show/{id}', name: 'app_article_detail')]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        //bonjour
        $repository = $entityManager->getRepository(Article::class);
        //ici $repository devient un objet voitureRepository
        $article = $repository->find($id);
        

        return $this->render('article/detail.html.twig', [
            'article' => $article,
            
        ]);
    }

    #[Route('/articles/magiques', name: "app_articles_magique")]
    public function articlesMagiques(ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->findArticlesWithMagicWord();

        return $this->render('article/magique.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/articles/{year}', name: 'app_articles_by_year')]
    public function articlesByYear(int $year, ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findArticlesByYear($year);

        return $this->render('article/year.html.twig', [
            'articles' => $articles,
            'year' => $year,
        ]);
    }

    

}
        