<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\User;

class HomeController extends Controller
{

    private function listFriends($id = 3) {
      $em = $this->getDoctrine()->getManager();
      $user = $this->getDoctrine()
      ->getRepository(User::class)
      ->find($id);
      $friends = $user->getFriends($em);

      return $friends;
    }
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(3);

        $friends = $this->listFriends($user->getId());
        return $this->render('home.html.twig', [
        	'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__),
        	'user' => $user,
          'friends' => $friends
        ]);
    }
}
