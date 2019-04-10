<?php


namespace App\Controller;






use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @Route("/back-office/utilisateurs")
     * @return Response
     */
    public function list():Response
    {
        //récupération du repository
        $repository = $this->getDoctrine()->getRepository(User::class);
        //récupération des articles
        $users = $repository->findAll();
        return $this->render('utilisateurs.html.twig', ['users' => $users
        ]);
    }

}