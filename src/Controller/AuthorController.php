<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/authors", name="author")
     */
    public function index(AuthorRepository $authorRepository)
    {
        $authors = $authorRepository->findAll();

        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }
}
