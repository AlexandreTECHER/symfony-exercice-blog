<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Post; 
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post_")
 */
class PostController extends AbstractController
{
    /**
     * @Route("s", name="browse")
     */
    public function browse(PostRepository $postRepository)
    {
        $getAllPosts = $postRepository->findAll();
        
        return $this->render('post/browse.html.twig', [
            'posts' => $getAllPosts,
        ]);
    }

    /**
     * @Route("/{id}", name="read", requirements={"id" = "\d+"})
     */
    public function read(Post $post, PostRepository $postRepository)
    {

        return $this->render('post/read.html.twig', [
            'post' => $post
        ]);
    }

        /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Post $post, EntityManagerInterface $em, Request $request)
    {

        if($request->getMethod() == 'POST'){

            $title = $request->request->get('title');
            $body = $request->request->get('body');
    
            $post->setTitle($title);
            $post->setBody($body);
    
            // $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_browse');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post
        ]);
    }

        /**
     * @Route("/add", name="add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        if($request->getMethod() == 'POST'){

            $title = $request->request->get('title');
            $body = $request->request->get('body');
    
            $post = new Post();
            $post->setTitle($title);
            $post->setBody($body);
            
            $authorRepository = $this->getDoctrine()->getRepository(Author::class);
            $author = $authorRepository->find(1);

            $post->setAuthor($author); 
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_browse');
        }

        return $this->render('post/add.html.twig');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Post $post, EntityManagerInterface $em)
    {
        $em->remove($post);

        $em->flush();
        
        return $this->redirectToRoute('post_browse');
    }
}
