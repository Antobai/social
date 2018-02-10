<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\Post;

use App\Form\PostType;

class PostController extends Controller
{
   /**
   * @Route("/posts/add", name="addPost")
   */
   public function addPost(Request $request) {

     $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');

     $em = $this->getDoctrine()->getManager();

     $user = $this->getUser();

     $post = new Post;
     $form = $this->createForm(PostType::class, $post);

     $form->handleRequest($request);
     if ($form->isSubmitted() && $form->isValid()) {

       $em = $this->getDoctrine()->getManager();
       $post->setDatetime(new \DateTime(date("Y-m-d")));
       $post->setUser($user);
       $em->persist($post);
       $em->flush();

       return $this->redirectToRoute('home');
     }

     $em->persist($post);
     $em->flush();

    return new Response('osef');

  }


}
