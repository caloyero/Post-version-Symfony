<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Usuarios;
use App\Form\PostType;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/* use Symfony\Component\BrowserKit\Request;
 */use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
      #[Route('/post', name: 'crear_post')]
    public function index(): Response
    {
      /*   $post = new Post();
        $formulario = $this->createForm(PostType::class,$post);
        $formulario->handleRequest($request); 
        if ($formulario->isSubmitted() && $formulario->isValid()) { 
            $postRepository->add($post, true);
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        } */

        return $this->render('post/crear.html.twig', [
            /* 'post'=> $post,
            'formulario'=> $formulario->createView(), */
        ]);
    }  
    
        #[Route('/creacionPost',name: 'creacion_post')]
    public function creacioPost(ManagerRegistry $doctrine,Request $request):Response
    {
        $request->get("usuario");
        $usuario = $doctrine->getRepository(Usuarios::class)->find($request->get("usuario"));
        $em = $doctrine->getManager();
        $post = new Post();
        $post->setTitulo($request->get("titulo"));
        $post->setContenido($request->get("contenido"));
        $post->setUsuarios($usuario);
        $em->persist($post);
        $em->flush();
 
        return $this->render('home/index.html.twig', [
            'posts'=>$post,
        ]);
    }
     /* #[Route('/{id}/post', name: 'crear_post' )]
    public function crear_post(Request $request,PostRepository $postRepository,Usuarios $usuario,$id):Response
    {

        $nuevo_post = new Post();
        $nuevo_post->getIdUsuario($id);
        $formulario = $this->createForm(Post::class,$nuevo_post,);
        $formulario->handleRequest($request); 

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $postRepository->add($nuevo_post, true);
            $id_usuario=$usuario->id;
            
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('post/crear.html.twig', [
            'nuevo_post' => $nuevo_post,
            'formulario' =>$formulario->createView()
        ]);
    }  */

   /*  #[Route('/crear', name: 'crear_post')]
    public function crear(Request $request, PostRepository $doctrine): Response
    
    {
        
        $usuarios = new Post();
        $form = $this->createForm(PostType::class, $usuarios);
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->add($usuarios, true);
            
            return $this->redirectToRoute('ver_usuarios', [], Response::HTTP_SEE_OTHER);
        } 

        return $this->render('post/crear.html.twig', [
            'usuario' => $usuarios,
            'form' => $form->createView(),
        ]);
    } */
}