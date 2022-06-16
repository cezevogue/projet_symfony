<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
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

        // ici on injecte en dépendance l'objet Request (de symfony\component\HttpFoundation) afin de traiter 
        //toutes les données provenants de nos superglobale ($_POST, $_GET .....), on injecte de même l'EntityManagerInterface (de Doctrine\ORM) afin d'effectuer toute les requêtes d'INSERT, de MODIFICATION ou de SUPPRESSION



        $produit=new Produit();
        //  ici on instancie un nouvel objet vide de la classe Produit
        //dd($produit);

        $form= $this->createForm(ProduitType::class, $produit, ['ajout'=>true]);
        // ici on instancie un objet Form qui attend en argument le formulaire (Type) avec lequel il doit se mettre en liens et en second argument l'objet qu'il va devoir remplir, il va de même effectuer grace à ces mises en liens les controles de concordance des champs de formulaires avec les propriétés présentes dans l'entité

        $form->handleRequest($request);
        // ici grace à la méthode handleRequest() notre objet est rempli des données du formulaire présentes dans notre objet $request (formulaire en méthode POST)
        //dd($produit);

        // condition de soumission et de validité du formulaire (ordre des conditions à respecter)
        if($form->isSubmitted() && $form->isValid()){

            // on récupère les informations de notre input type File de la propriété 'photo1'
            $photo1=$form->get('photo1')->getData();
            //dd($photo1);
            // on renomme le fichier d'upload de l'input 'photo1'
            $photo1_name=date('YmdHis').$photo1->getClientOriginalName();
            //dd($photo1_name);

            // on upload le fichier temporaire dans l'application grace à la méthode move() qui prend en parametre la destination de l'upload et le nom du fichier uploadé
            $photo1->move($this->getParameter('upload_directory'), $photo1_name);

            $produit->setPhoto1($photo1_name);


            $photo2=$form->get('photo2')->getData();

           if(!empty($photo2)){
                  $photo2_name=date('YmdHis').$photo2->getClientOriginalName();
            $photo2->move($this->getParameter('upload_directory'), $photo2_name);
            $produit->setPhoto2($photo2_name);
         
           }
      
            $photo3=$form->get('photo3')->getData();

             if(!empty($photo3)){
                        $photo3_name=date('YmdHis').$photo3->getClientOriginalName();
                        $photo3->move($this->getParameter('upload_directory'), $photo3_name);
                        $produit->setPhoto3($photo3_name);

             }
          
             // on appel le manager de EntityManagerInterface pour préparer la requête avec sa méthode persist() qui attend en parametre l'objet à envoyer en BDD
             $manager->persist($produit);

             // on demande au manager d'éxecuter la ou les requete préparées 
              $manager->flush();


        }// fermeture de condition de soumission du formulaire



     

     
     return $this->render("admin/ajoutProduit.html.twig",[
        'form'=>$form->createView()


     ] ) ;
    }// fermeture ajoutProduit


    /**
    *@Route("/listeProduit", name="listeProduit") 
    */
    public function listeProduit(  ProduitRepository $produitRepository   )
    {

        $produits=$produitRepository->findAll();
     
     
     return $this->render("admin/listeProduit.html.twig",[
            'produits'=>$produits

     ] ) ;
    }

    /**
    *@Route("/modificationProduit/{id}", name="modificationProduit") 
    */
    public function modificationProduit( Produit $produit , EntityManagerInterface $manager, Request $request   )
    {


        // si un parametre {id} est présent dans l'url et que l'on injecte en dépendance de la fonction une entité. Symfony va par lui même effectuer la requête find($id) du repository en liens avec l'entité 

        $form=$this->createForm(ProduitType::class, $produit, ['modification'=>true]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
         {
            




        }


     
     
     return $this->render("admin/modificationProduit.html.twig",[
        'form'=>$form->createView(),
        'produit'=>$produit
     ] ) ;
    }







}// fermeture du controller
