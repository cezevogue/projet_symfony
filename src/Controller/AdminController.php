<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
   
    /**
    *@Route("/ajoutProduit", name="ajoutProduit") 
    */
    public function ajoutProduit(Request $request, EntityManagerInterface $manager)
    {

        // ici on injecte en dépendance l'ojet Request (de symfony)



        $produit=new Produit();

        $form= $this->createForm(ProduitType::class, $produit);

        $form->handleRequest($request);

     

     
     return $this->render("admin/ajoutProduit.html.twig",[
        'form'=>$form->createView()


     ] ) ;
    }








}// fermeture du controller
