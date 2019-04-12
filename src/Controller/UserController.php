<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\UserEditRoleType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class UserController extends AbstractController
{
    /**
     * @Route("/back-office/utilisateurs")
     * @return Response
     */
    public function list(): Response
    {
        // Récupération du Repository
        $repo = $this->getDoctrine()->getRepository(User::class);
        // Récupération des utilisateurs
        $users = $repo->findAll();
        // Renvoi des utilisateurs à la vue
        return $this->render('user/list.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/back-office/utilisateurs/changement-roles/{id}",name="app_user_editrole", requirements={"id"="[0-9]+"})
     * @param int $id
     * @return Response
     */
    public function edit(int $id, Request $request): Response
    {
        // Récupération du Repository
        $repo = $this->getDoctrine()->getRepository(User::class);
        // Récupération des utilisateurs
        $user = $repo->findOneBy([
            'id' => $id
        ]);
        // Instanciation du formulaire
        $form = $this->createForm(UserEditRoleType::class, $user);
        // Renvoi des utilisateurs à la vue

        // on rempli le formulaire avec les données testées
        $form->handleRequest($request);

        // on vérifie que le formulaire a été soumis et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            //recupération du manager ça sert à pousser des infos dans la BDD
            $manager = $this->getDoctrine()->getManager();
            //Insertion de l'article dans la BDD
            $manager->flush();//execution du SQL}
            // ajout d'un message flash
            $this->addFlash('primary', 'role modifié');
            //Redirection
            return $this->render('edit/show.html.twig', [
                'user' => $user,
                'editForm' => $form->createView()
            ]);
        }
    }
}