<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Comentarios;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Post::class);
        $post = $repository->findAll();
        
       /*  if(!$post)
        {
            $post = 0;
            return $this->render('home/index.html.twig', [
                'controller_name' => 'Pagina de Inicio',
                'posts'=>0,]);
        } */
        /* throw $this->createNotFoundException("No existe un post actualmente"); */
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Pagina de Inicio',
            'posts'=>$post,
        ]);
    }
}