<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Service\Panier\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
 
    /**
    *@Route("/", name="home") 
    */
    public function home(  ProduitRepository $produitRepository    )
    {
     // on injecte en dépendance le repository de Produit afin de pouvoir récupérer les données de la table produit en BDD
     // Les repository sont systématiquement appelé pour effectuer les requêtes de SELECT en BDD
     // On utilise sa méthode findAll() pour récupérer toutes les données ( equivaut à SELECT * FROM produit)
     $produits=$produitRepository->findAll();
        
     
     return $this->render("home/home.html.twig",[

        'produits'=>$produits

     ] ) ;
    }

    /**
    *@Route("/ajoutPanier/{id}", name="ajoutPanier") 
    */
    public function ajoutPanier(PanierService $panier, $id )
    {
     $panier->ajout($id);

     //dd($panier->detailPanier());

     $this->addFlash('success', 'Ajouté au panier !!!');
     
     return $this->redirectToRoute("home",[] ) ;
    }

    /**
    *@Route("/panier", name="panier") 
    */
    public function panier(PanierService $panierService)
    {
     
        $panier=$panierService->detailPanier();
     
     return $this->render("home/panier.html.twig",[
        'panier'=>$panier
     ] ) ;
    }








}// fermeture du controller
