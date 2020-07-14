<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/post/{post}/comment", name="post_comment_", requirements={"post": "\d+"})
*/
class CommentController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     */
    public function add(Post $post, Request $request)
    {

        if($request->getMethod() == 'POST'){

            $username = $request->request->get('username');
            $body = $request->request->get('body');

            $comment = new Comment();
            $comment->setUsername($username);
            $comment->setBody($body);
            $comment->setPost($post);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('post_read', ['id' => $post->getId()]);
        }
        return $this->render('comment/add.html.twig', [
            'post' => $post
        ]);
    }
}
