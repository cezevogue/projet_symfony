<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
   
    /**
    *@Route("/ajoutProduit", name="ajoutProduit") 
    */
    public function ajoutProduit()
    {
     
        
     
     return $this->render("admin/ajoutProduit.html.twig",[] ) ;
    }








}// fermeture du controller
