<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentFrontType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route ("/", name="article_list")
     * @return Response
     */
    public function index(): Response
    {
        //récupération du repository
        $repository = $this->getDoctrine()->getRepository(Article::class);
        //récupération des articles
        $articles = $repository->findAll();

        return $this->render('article/index.html.twig', ['articles' => $articles
        ]);
    }

    /**
     * @Route("/article/creation", name="article_create")
     * @return Response
     */
    public function create(Request $request): Response
    {
        $article = new Article();
        //récupération du formulaire
        $form = $this->createForm(ArticleType::class, $article);
        // on rempli le formulaire avec les données testées
        $form->handleRequest($request);

        // on vérifie que le formulaire a été soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            //recupération du manager ça sert à pousser des infos dans la BDD
            $manager = $this->getDoctrine()->getManager();
            //Insertion de l'article dans la BDD
            $manager->persist($article);//Préparation du SQL
            $manager->flush();//execution du SQL}
            // ajout d'un message flash
            $this->addFlash('success', 'vote message a bien été ajouté');
            //Redirection
            return $this->redirectToRoute('article_show', [
                'id' => $article->getId()]);

//envoi du formulaire dans la vue
            return $this->render('article/create.html.twig', [
                'createForm' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/article/{id}", name="article_show", methods={"GET","POST"})
     * @param Article/$article
     * @return Response
     */
    public function show(Article $article, Request $request)
    {
        // Création du formulaire pour l'ajout de commentaire
        $newComment = new Comment();
        $newComment->setArticle($article);
        $commentForm = $this->createForm(CommentFrontType::class, $newComment);
        // Gestion de l'ajout d'un commentaire
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newComment);
            $manager->flush();
            // Création du nouveau formulaire après qu'on ait rempli le premier
            $newComment = new Comment();
            $newComment->setArticle($article);
            $commentForm = $this->createForm(CommentFrontType::class, $newComment);
        }
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView()
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

    /**
     * @Route("/article/{id}/modification", name="article_update")
     * @param Article $article
     * @return Response
     * @throws \Exception
     */
    public function edit(Article $article, Request $request): Response
    {
        //récupération du formulaire
        $form = $this->createForm(ArticleType::class, $article);
        // le truc qui appelle l'article c'est le param converteur

        // on rempli le formulaire avec les variables POST
        $form->handleRequest($request);

        // on vérifie que le formulaire a été soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            //recupération du manager ça sert à pousser des infos dans la BDD
            $manager = $this->getDoctrine()->getManager();
            //Mise a jour de l'article dans la BDD
            $manager->flush();//execution du SQL}
            // ajout d'un message flash
            $this->addFlash('primary', 'votre message a bien été modifié');
            //Redirection


            return $this->redirectToRoute('article_show', [
                'id' => $article->getId()
            ]);
        }// on passe le formulaire à twig pour récupérer la vue
            // on vérifie que le formulaire a été soumis et qu'il est valide
        return $this->render('article/update.html.twig', [
            'editForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{id}/suppression", name="article_delete")
     * @param Article $article
     * @return Response
     */
    public function delete(Article $article): Response
    {
        //recupération du manager ça sert à pousser des infos dans la BDD
        $manager = $this->getDoctrine()->getManager();
        //suppression de l'article
        $manager->remove($article);
        //Mise a jour de l'article dans la BDD
        $manager->flush();//execution du SQL}
        // ajout d'un message flash
        $this->addFlash('danger', 'Votre messsage a bien été supprimé');
        //redirection vers la liste des articles
        return $this->redirectToRoute('article_list');
    }
}
