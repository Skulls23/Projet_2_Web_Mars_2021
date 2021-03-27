<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Etablissement;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\EtablissementRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;
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
    public function supprimer(): Response
    {
        if( !isset($_POST['id']))
            return $this->render('commentaire/supprimer/supprimer.html.twig', array("message" => "Suppression"));

        $manager = $this->getDoctrine()->getManager();
        $reposit = $manager->getRepository(Commentaire::class);

        if($reposit->find(intval(htmlspecialchars($_POST['id']))) == null)
            return $this->render("commentaire/supprimer/supprimer.html.twig", array("message" => "Commentaire introuvable"));

        $manager->remove($reposit->find(intval(htmlspecialchars($_POST['id']))));
        $manager->flush();

        return $this->render("commentaire/supprimer/supprimer.html.twig", array("message" => "suppression effectué"));
    }

    #[Route('/commentaires/{id}/modifier', name: "modifierCommentaire")]
    public function modifier(Request $req, int $id ): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $reposit = $manager->getRepository(Commentaire::class);

        $com = $id > -1 ? $reposit->find($id) : new Commentaire();

        $form = $this->createForm(CommentaireType::class, $com);
        $form->handleRequest($req);
        if(! $form->isSubmitted())
        $form["uai2"]->setData($com->getUai()->getUai());

        $com->setUai($manager->getRepository(Etablissement::class)->findByUAI($form->get("uai2")->getData()));

        if( $form->isSubmitted() && $form->isValid() )
        {
            $manager->persist($com);
            $manager->flush();
        }

        return $this->render('commentaire/modifier_inserer/formulaire.html.twig', array("form" => $form->createView()));
    }

    #[Route('/commentaires/inserer', name: "insererCommentaire")]
    public function inserer(Request $req): Response
    {
        return $this->modifier($req, -1);
    }
}
