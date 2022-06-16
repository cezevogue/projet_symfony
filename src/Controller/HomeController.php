<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
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








}// fermeture du controller
