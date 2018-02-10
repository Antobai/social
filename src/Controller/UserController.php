<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\User;
use App\Entity\Post;

use Doctrine\ORM\Query\ResultSetMapping;

class UserController extends Controller
{

  /**
   * @Route("/posts/add", name="addPost")
   */
   public function addPost() {

     $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');

     $em = $this->getDoctrine()->getManager();

     $user = $this->getUser();

     $post = new Post;
     $post->setUser($user);
     $post->setDatetime(new \DateTime(date("Y-m-d")));
     $post->setImg("img.png");
     $post->setContent("This is a post");

     $em->persist($post);
     $em->flush();

     return $this->redirectToRoute('home');

  }

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

    /**
     * @Route("/user/{id}", name="userDetails")
     */
     public function userDetails($id) {

       $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');
       $currentUser = $this->getUser();
       $user = $this->getDoctrine()
       ->getRepository(User::class)
       ->find($id);


       return $this->render('userDetails.html.twig', [
        'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__),
        'currentUser' => $currentUser,
        'user' => $user,
       ]);

    }




}
