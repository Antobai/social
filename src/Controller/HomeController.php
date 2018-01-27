<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\User;

class HomeController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(3);

        $friends = $user->getFriends($em);
        return $this->render('home.html.twig', [
        	'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__),
        	'user' => $user,
          'friends' => $friends
        ]);
    }
}
