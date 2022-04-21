<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    #[Route('/categorie/ajouter', name: 'categorie_ajouter')]
    public function categorieAjout(Request $request) : Response{
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class , $categorie);
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){

                $em = $this->getDoctrine()->getManager();
                $em->persist($categorie);
                $em->flush();
                return $this->redirectToRoute("categorie_liste");

            }




        return $this->render('categorie/ajouter.html.twig' ,[
            'formulaire'=>$form->createView()
        ]);
    }
    #[Route('/categorie/liste', name: 'categorie_liste')]
    public function listeCategorie():Response{
        $repo = $this->getDoctrine()->getRepository(Categorie::class);
        $liste_categorie = $repo->findAll();



        return $this->render('categorie/liste.html.twig' , [
            'liste_categorie'=>$liste_categorie
        ]);
    }
    #[Route('/categorie/supprimer/{id}', name: 'categorie_supprimer')]
    public function supprimerCategorie($id): Response{
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository(Categorie::class)->find($id);
        $em->remove($categorie);
        $em->flush();



        return $this->redirectToRoute('categorie_liste');
    }
    #[Route('/categorie/modifier/{id}', name: 'categorie_modifier')]
    public function modifierCategorie(Request $request , $id):Response{
        $em = $this->getDoctrine()->getManager();
        $categorieData = $em->getRepository(Categorie::class)->find($id);
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class , $categorie);
        $form->handleRequest($request);
        $formData = $form->getData();

        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $categorie = $em->getRepository(Categorie::class)->find($id);
            $categorie->setNom($formData->getNom());
            $em->flush();
            return $this->redirectToRoute('categorie_liste');

        }

         return $this->render('categorie/modifier.html.twig' ,[
            'data'=> $categorieData ,
            'form'=> $form->createView()
         ]);
    }
  
}