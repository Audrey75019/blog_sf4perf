<?php

namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route ("/article", name="article_list")
     * @return Response
     */
    public function index(): Response
    {
        //récupération du repository
        $repository =$this->getDoctrine()->getRepository(Article::class);
        //récupération des articles
        $articles = $repository->findAll();

        return $this->render('article/index.html.twig', ['articles'=>$articles
            ]);
    }

    /**
     * @Route("/article/creation", name="article_create")
     * @return Response
     */
    public function create(): Response
    {
        $article=new Article();
        //récupération du formulaire
        $form = $this->createForm(ArticleType::class, $article);
        //envoi du formulaire dans la vue
        return $this->render('article/create.html.twig', [
            'createForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show($id)
    {
        //récupétation du repository
        $repository =$this->getDoctrine()->getRepository(Article::class);
        //récupération de l'article lié a l'id
        $article = $repository->findOneBy([
            'id'=>$id
        ]);
        return $this->render('article/show.html.twig', ['articles'=>$article
        ]);
    }

    /**
     * @Route("/")
     * @return Response
     */
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/about")
     * @return Response
     */
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    /**
     * @Route("/contact")
     * @return Response
     */
    public function contact(): Response
    {
        return $this->render('contact.html.twig');
    }

}

