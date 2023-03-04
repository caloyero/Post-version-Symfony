<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Form\UsuariosType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UsuariosRepository;

class UsuariosController extends AbstractController
{
    #[Route('/usuarios',name:'app_usuarios')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $usuario = $doctrine->getRepository(Usuarios::class)->findAll();

        return $this->render('usuarios/index.html.twig',[
            'controller_name' => 'UsuariosController',
            'usuarios' => $usuario, 
        ]);
    }

    /*  ver Usuarios */

    #[Route('/ver_usuarios/{id}', name:'ver_usuario')]
    public function ver_usuario(ManagerRegistry $doctrine , $id): Response
    {
        $usuario = $doctrine->getRepository(Usuarios::class)->find($id);

        return $this->render('usuarios/show.html.twig',[
            'usuario'=>$usuario
        ]);
    }

    /* editar usuario */

    #[Route('/{id}/editar', name: 'editar_usuario')]
    public function editar(Request $request,UsuariosRepository $usuariosRepository,ManagerRegistry $doctrine,$id): Response
    {
        $repositorio = $doctrine->getManager();
        $usuario = $repositorio->getRepository(Usuarios::class)->find($id); 

        $formulario = $this->createForm(UsuariosType::class,$usuario);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $usuariosRepository->add($usuario, true);
            return $this->redirectToRoute('app_usuarios', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('usuarios/editar.html.twig', [
            'usuario' => $usuario,
            'formulario' =>$formulario->createView(),
        ]);
    }

    #[Route('/crear',name: 'crear_usuario')]
    public function crear(Request $request,UsuariosRepository $doctrine):Response
    {
        $usuario = new Usuarios();
        $formulario = $this->createForm(UsuariosType::class,$usuario);
        $formulario->handleRequest($request);

        if($formulario->isSubmitted() && $formulario->isValid())
        {
            $doctrine->add($usuario, true);
            return $this->redirectToRoute('app_usuarios', [], Response::HTTP_SEE_OTHER);

        }
        return $this->render('usuarios/crear.html.twig', [
            'usuario' => $usuario,
            'formulario' => $formulario->createView(),
        ]); 
    }
}