<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\Post;
use App\Entity\User;

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
       $post->setDatetime(new \DateTime(date("Y-m-d H:i:s")));
       $post->setUser($user);
       $em->persist($post);
       $em->flush();

       return $this->redirectToRoute('home');
     }
     return $this->redirectToRoute('home');

  }

  /**
   * @Route("/myposts", name="myPosts")
   */
  public function myPosts(Request $request)
  {
      $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');

      $em = $this->getDoctrine()->getManager();
      $user = $this->getUser();

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

      $posts = $this->getDoctrine()
      ->getRepository(Post::class)
      ->findBy(
          ['user' => $user],
          ['datetime' => 'DESC']
      );

      $post = new Post();
      $form = $this->createForm(PostType::class, $post,array(
          'action' => $this->generateUrl('addPost'),
          'method' => 'POST',
      ));

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {


          $em = $this->getDoctrine()->getManager();
          $em->persist($post);
          $em->flush();

          // ... do any other work - like sending them an email, etc
          // maybe set a "flash" success message for the user

          return $this->redirectToRoute('home');
      }


      return $this->render('home.html.twig', [
        'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__),
        'currentUser' => $user,
        'friends' => $friends,
        'potentialFriends' => $potentialFriends,
        'users' => $users,
        'posts' => $posts,
        'postForm' => $form->createView()
      ]);
  }


}
