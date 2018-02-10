<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
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


}
