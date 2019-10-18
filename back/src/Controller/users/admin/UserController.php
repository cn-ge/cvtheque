<?php

namespace App\Controller\users\admin;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController{

    const TEMPLATE_HOME_PATH        = "users/list.html.twig";
    const TEMPLATE_EDIT_PATH        = "users/edit.html.twig";

    const ROUTE_LIST                = 'admin.users.list';
    
    const MENU                      = 'users';
    
    /**
     * @var Environnement
     * Variable de type service
     */
    private $twig;

    private $manager;

    public function __construct(Environment $twig, ObjectManager $manager)
    {
        $this->twig = $twig;
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/users/list", name="admin.users.list")
     * @return Response
     */
    public function list (): Response {
        $users = $this->manager->getRepository(User::class)->findAll();
        return new Response($this->twig->render(self::TEMPLATE_HOME_PATH, [
            'menu' => self::MENU,
            'users' => $users
          ]
        ));
    }

    /**
     * @Route("/admin/users/{id}", name="admin.users.edit")
     * @return Response
     */
    public function edit (User $user, Request $request, String $role = null): Response {
      $role = $request->get('role');
      if (is_null($role)) {
        return new Response($this->twig->render(self::TEMPLATE_EDIT_PATH, [
            'menu' => self::MENU,
            'user' => $user
          ]
        ));
      } else {
        $user->removeRoles();
        $user->addRole($role);
        $this->manager->flush($user);
        $this->addFlash("success", 'Utilisateur modifié avec succès !');
        return $this->redirectToRoute(self::ROUTE_LIST, [
            'menu' => self::MENU
        ]);
      }
    }
    
    /**
     * @Route("/admin/users/delete/{id}", name="admin.users.delete")
     * @return Response
     */
    public function delete (User $user, Request $request): Response {

      $this->em->flush();
      $this->addFlash("success", 'Utilisateur supprimé !');
      return $this->redirectToRoute(self::ROUTE_LIST, [
          'menu' => self::MENU
      ]);
    }
}