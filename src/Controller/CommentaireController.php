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

    #[Route('/commentaires/vue', name: 'getVueSansPageSelectEtablissement')]
    public function getVueSansPageSelectEtablissement(): Response
    {
        return $this->redirect('/commentaires/vue/1');
    }

    #[Route('/commentaires/vue/{page}', name: "selectVueCommentaire")]
    public function select_vue(int $page): Response
    {
        if( $page == 0 ) $page = 1;

        $page = abs($page);

        $manager        = $this->getDoctrine()->getManager()->getRepository(Etablissement::class);
        $etablissements = $manager->findBy(array(), orderBy: array("id" => "ASC"), limit: 50, offset: ($page-1)*50);

        return $this->render('commentaire/vue/vueEtablissements.html.twig', array("page_10"=>$page > 10 ? $page-10 : -1,
            "page_1" =>$page >  1 ? $page- 1 : -1,
            "page1"  =>$page+1,
            "page10"=>$page+10,
            "page100"=>$page+100,
            "page"=>$page,
            "etablissements"=>$etablissements));
    }

    #[Route('/commentaires/vue/{uai}', name: 'getVueSansPageCommentaires')]
    public function getVueSansPage($uai): Response
    {
        return $this->redirect('/commentaires/vue/'.$uai.'/1');
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
        if(! $form->isSubmitted() && $com->getEtablissement() != null)
            $form["uai2"]->setData($com->getEtablissement()->getUai());

        $com->setEtablissement($manager->getRepository(Etablissement::class)->findByUAI($form->get("uai2")->getData()));

        if( $form->isSubmitted() && $form->isValid() )
        {
            $manager->persist($com);
            $manager->flush();
        }

        return $this->render('commentaire/modifier_inserer/formulaire.html.twig', array("form" => $form->createView()));
    }

    #[Route('/commentaires/modifier/{page}', name: "selectModifierCommentaire")]
    public function select_modifier(int $page): Response
    {
        if( $page == 0 ) $page = 1;

        $page = abs($page);

        $manager        = $this->getDoctrine()->getManager()->getRepository(Commentaire::class);
        $commentaire = $manager->findBy(array(), orderBy: array("id" => "ASC"), limit: 50, offset: ($page-1)*50);

        return $this->render('commentaire/modifier/modifier_viewAll.html.twig', array("page_1"=>$page > 1 ? $page-1 : -1,
            "page_2"=>$page >  2 ? $page-2 : -2,
            "page1" =>$page+1,
            "page2" =>$page+2,
            "page3" =>$page+3,
            "page"  =>$page,
            "commentaires"=>$commentaire));
    }

    #[Route('/commentaires/modifier', name: "selectFirstModifierCommentaire")]
    public function select_modifierFirst(): Response
    {
        return $this->redirect('/commentaires/modifier/1');
    }


    #[Route('/commentaires/inserer', name: "insererCommentaire")]
    public function inserer(Request $req): Response
    {
        return $this->modifier($req, -1);
    }
}
