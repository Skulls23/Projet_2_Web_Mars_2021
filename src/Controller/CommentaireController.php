<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Etablissement;
use App\Repository\CommentaireRepository;
use App\Repository\EtablissementRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use http\Env\Request;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    #[Route('/commentaires', name: 'commentaire')]
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

    #[Route('/commentaires/vue/{uai}/{pages}', name: 'getVueCommentaire')]
    public function getVue($uai, int $pages):Response
    {
        $tabCommmentaire = $this->getDoctrine()->getManager()->getRepository(Commentaire::class)->findByUAI($uai,$pages);
        return $this->render("commentaire/vue/vue.html.twig", array("page1"=>$pages+1, "page2"=>$pages+2, "page3"=>$pages+3,
            "page_1"=>$pages-1, "page_2"=>$pages-2, "commentaires"=>$tabCommmentaire, "uai"=>$uai));
    }

    #[Route('/commentaires/supprimer', name: "supprimerCommentaire")]
    public function supprimer(Request $request): Response
    {
        return $this->render("commentaire/supprimer/supprimer.html.twig", array());
    }

    #[Route('/commentaires/modifier/{id}', name: "modifierCommentaire")]
    public function modifier($id): Response
    {
        //return $this->render("commentaire/supprimer/supprimer.html.twig", array("id"=>$id));
        return new Response("");
    }
}
