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
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $users = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();



        $friends = $user->getFriends($em);
        dump($friends);
        return $this->render('home.html.twig', [
        	'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__),
        	'currentUser' => $user,
          'friends' => $friends,
          'users' => $users
        ]);
    }
}
