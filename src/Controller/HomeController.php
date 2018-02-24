<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Entity\Post;

use App\Form\PostType;


class HomeController extends Controller
{

    /**
     * @Route("/home/{myposts}", name="home", defaults={"myposts"=false})
     */
    public function index(Request $request, $myposts)
    {

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        //get current user
        $user = $this->getUser();

        //get All users (for dev purposes)
        $users = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();

        //get friendShips
        $friendships = $user->getFriends();

        //make an array of friends from friendships
        $friends = array();
        foreach ($friendships as $key => $friendship) {
          array_push($friends,$friendship->getFriend());
        }

        //get all users except friends
        $potentialFriends = $users;
        /* Unset current friends from friends suggestions, need to refactor this with a query*/
        foreach ($users as $key => $potentialFriend) {
          if(in_array($potentialFriend,$friends) ) {
            unset($potentialFriends[$key]);
          }
        }

        if($myposts === false) {
          //get all posts from friends
          $posts = $this->getDoctrine()
          ->getRepository(Post::class)
          ->findBy(
              ['user' => $friends],
              ['datetime' => 'DESC']
          );
        }
        else {
          //get all posts from user
          $posts = $this->getDoctrine()
          ->getRepository(Post::class)
          ->findBy(
              ['user' => $user],
              ['datetime' => 'ASC']
          );
        }



        //build the new post form
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
