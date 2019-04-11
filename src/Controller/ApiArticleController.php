<?php


namespace App\Controller;


use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiArticleController extends AbstractController
{
    /**
     * @Route("/api/article/likes/{id}")
     * @return JsonResponse
     */
    public function incrementLikes($id): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->findOneBy([
            'id'=>$id
        ]);

        $likes = $article->getLikes() + 1;
        $article->setLikes($likes);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($article);
        $manager->flush();

        return $this->json([
            'cpt'=>$likes
        ]);
    }



}