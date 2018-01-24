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
     * @Route("/user/add", name="addUser")
     */
    public function addUser()
    {
      // you can fetch the EntityManager via $this->getDoctrine()
      // or you can add an argument to your action: index(EntityManagerInterface $em)
      $em = $this->getDoctrine()->getManager();

      $user = new User();
      $user->setLastname('Bailly');
      $user->setFirstname("Antonin");
      $user->setImg("img.png");
      $user->setBirth(new \DateTime(date("Y-m-d",  mktime(0, 0, 0, 4, 1, 1991))));

      // tell Doctrine you want to (eventually) save the Product (no queries yet)
      $em->persist($user);

      // actually executes the queries (i.e. the INSERT query)
      $em->flush();

      return new Response('Saved new user with id '.$user->getId());

    }

    /**
     * @Route("/user/add", name="addUser")
     */
    public function addFriends() {

      $em = $this->getDoctrine()->getManager();

        $friend1 = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(3);

        $friend2 = $this->getDoctrine()
        ->getRepository(User::class)
        ->find(4);

        $rsm = new ResultSetMapping();

        $query = $em->createNativeQuery('INSERT INTO user_user (user_source, user_target) VALUES (?,?)' , $rsm);
        $query->setParameter(1, $friend1->getId());
        $query->setParameter(21, $friend2->getId());


        return new Response('Saved new friends with id '.$friend1->getId().' '.$friend2->getId());

    }

    public function listFriends($id = 3) {
      
    }

}
