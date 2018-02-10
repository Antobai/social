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
        dump($user);

        $users = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();

        $potentialFriends = $users;

        $friends = $user->getFriends($em);

        /* Unset current friends from friends suggestions, need to refactor this with a query*/
        foreach ($users as $key => $potentialFriend) {
          if(in_array($potentialFriend,$friends) ) {
            unset($potentialFriends[$key]);
          }
        }



        return $this->render('home.html.twig', [
        	'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__),
        	'currentUser' => $user,
          'friends' => $friends,
          'potentialFriends' => $potentialFriends,
          'users' => $users
        ]);
    }
}
