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


      $em = $this->getDoctrine()->getManager();

      $friend1 = $this->getUser();

      $friend2 = $this->getDoctrine()
      ->getRepository(User::class)
      ->find($id);


      $friend1->addFriend($friend2);
      $em->persist($friend1);
      $em->flush();
      dump($friend1);

      $friend2->addFriend($friend1);
      $em->persist($friend2);
      $em->flush();


      return new Response('Saved new friends with id '.$friend1->getId().' '.$friend2->getId());



    }




}
