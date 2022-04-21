<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/ajouter', name: 'app_ajouter')]
    public function ajouterAnnonce(Request $request) : Response{
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class , $annonce);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('app_liste');

        }






        return $this->render('admin/ajouterAnnonce.html.twig' ,[
            'formulaire'=>$form->createView()

        ]);
    }
    #[Route('/admin/liste', name: 'app_liste')]
    public function liste() : Response{
        $repo = $this->getDoctrine()->getRepository(Annonce::class);
        $liste_annonce = $repo->findAll();

        return $this->render('admin/liste.html.twig' ,[
                'liste_annonce'=> $liste_annonce
        ]);
    }
    #[Route('/admin/supprimer/{id}', name: 'app_supprimer')]
    public function supprimer($id):Response{
        $em =$this->getDoctrine()->getManager();
        $annonce = $em->getRepository(Annonce::class)->find($id);
        $em->remove($annonce);
        $em->flush();




        return $this->redirectToRoute('app_liste');

    }

}
