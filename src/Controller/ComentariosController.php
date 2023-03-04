<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Entity\Post;
use App\Entity\Comentarios;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComentariosController extends AbstractController
{
    #[Route('/comentarios', name: 'comentarios')]
    public function index(Request $request,ManagerRegistry $doctrine): Response
    {
        $post = $doctrine->getRepository(Post::class)->find($request->get("post"));
        $usuario = $doctrine->getRepository(Usuarios::class)->find($request->get("usuario"));
      /*   echo $post->getId();
        echo $request->get("usuario"); */
        $em = $doctrine->getManager();
        $comentario = new Comentarios();
        $comentario->setComentario($request->get("contenido"));
        $comentario->setUsuarios($usuario);
        $comentario->setPost($post);
        $em->persist($comentario);
        $em->flush(); 


        return $this->render('home/index.html.twig', [
            'controller_name' => 'ComentariosController',
        ]);
    }
}