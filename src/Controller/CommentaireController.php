<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Etablissement;
use App\Repository\CommentaireRepository;
use App\Repository\EtablissementRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
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

    #[Route('/commentaires/vue/{uai}', name: 'getVueCommentaire')]
    public function getVue($uai):Response
    {
        $tabCommmentaire = $this->getDoctrine()->getManager()->getRepository(Commentaire::class)->findByUAI($uai);
        $sRet = "";
        foreach ($tabCommmentaire as $commentaire)
           $sRet .= $commentaire->toString();
        return new Response($sRet);
    }

    #[Route('/commentaires/supprimer', name: "supprimerCommentaire")]
    public function supprimer(): Response
    {
        return new Response("supprimer vide pour le moment");
    }

    #[Route('/commentaires/modifier_inserer', name: "modifierCommentaire")]
    public function modifier(): Response
    {
        return new Response("modifier_inserer vide pour le moment");
    }
}
