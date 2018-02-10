<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\User;

use Doctrine\ORM\Query\ResultSetMapping;

class UserController extends Controller
{

    /**
     * @Route("/friends/add/{id}", name="addFriends")
     */
     public function addFriends($id) {

      $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');

      $em = $this->getDoctrine()->getManager();

      $user = $this->getUser();

      $friend = $this->getDoctrine()
      ->getRepository(User::class)
      ->find($id);


      $user->addFriend($friend);
      $em->persist($user);
      $em->flush();

      $friend->addFriend($user);
      $em->persist($friend);
      $em->flush();


      return $this->redirectToRoute('home');



    }




}
