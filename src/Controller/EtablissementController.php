<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Form\EtablissementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    #[Route('/etablissements', name: 'etablissement')]
    public function index(): Response
    {
        return $this->render('etablissement/index.html.twig', [
            'controller_name' => 'EtablissementController',
        ]);
    }

    #[Route('/etablissements/vue', name: 'getVueSansPageEtablissement')]
    public function getVueSansPage(): Response
    {
        return $this->redirect('/etablissements/vue/1');
    }

    #[Route('/etablissements/vue/{page}', name: 'getVueEtablissement')]
    public function getVue(int $page): Response
    {
        if( $page == 0 ) $page = 1;

        $page = abs($page);

        $manager        = $this->getDoctrine()->getManager()->getRepository(Etablissement::class);
        $etablissements = $manager->findBy(array(), orderBy: array("id" => "ASC"), limit: 50, offset: ($page-1)*50);

        return $this->render('etablissement/vue/vue.html.twig', array("page"=>$page,
                                                                           "page_10"=>$page > 10 ? $page-10 : -1,
                                                                           "page_1" =>$page >  1 ? $page- 1 : -1,
                                                                           "page1"  =>$page+1,
                                                                           "page10"=>$page+10,
                                                                           "page100"=>$page+100,
                                                                           "etablissements"=>$etablissements));
    }

    #[Route('/etablissements/supprimer', name: "supprimerEtablissement")]
    public function supprimer(): Response
    {
        if( !isset($_POST['uai']) && !isset($_POST['id']))
            return $this->render('etablissement/supprimer/supprimer.html.twig', array("message" => ""));

        $manager = $this->getDoctrine()->getManager();
        $reposit = $manager->getRepository(Etablissement::class);

        if( isset($_POST['uai']) && !isset($_POST['id']))
        {
            $etablissement = $reposit->findBy(array("uai" => htmlspecialchars($_POST['uai'])));

            if( $etablissement == null ||count($etablissement) == 0 )
                return $this->render('etablissement/supprimer/supprimer.html.twig', array("message" => "not found"));

            return $this->render('etablissement/supprimer/supprimer_confirmation.html.twig', array("nom" => $etablissement[0]->getAppellationOfficelle(),
                "id" => $etablissement[0]->getId(), "code_postal" => $etablissement[0]->getCodePostal()));
        }
        else
        {
            $manager->remove($reposit->find(intval(htmlspecialchars($_POST['id']))));
            $manager->flush();

            return $this->render('etablissement/supprimer/supprimer.html.twig', array("message" => "suppression effectué"));
        }
    }

    #[Route('/etablissements/{id}/modifier', name: "modifierEtablissement")]
    public function modifier( Request $req, int $id ): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $reposit = $manager->getRepository(Etablissement::class);

        $et = $id > -1 ? $reposit->find($id) : new Etablissement();

        $form = $this->createForm(EtablissementType::class, $et);
        $form->handleRequest($req);

        if( $form->isSubmitted() && $form->isValid() )
        {
            $manager->persist($et);
            $manager->flush();
        }

        return $this->render('etablissement/modifier_inserer/formulaire.html.twig', array("form" => $form->createView()));
    }

    #[Route('/etablissements/modifier/{page}', name: "selectModifierEtablissement")]
    public function select_modifier(int $page): Response
    {
        if( $page == 0 ) $page = 1;

        $page = abs($page);

        $manager        = $this->getDoctrine()->getManager()->getRepository(Etablissement::class);
        $etablissements = $manager->findBy(array(), orderBy: array("id" => "ASC"), limit: 50, offset: ($page-1)*50);

        return $this->render('etablissement/modifier/modifier_viewAll.html.twig', array("page_10"=>$page > 10 ? $page-10 : -1,
            "page_1" =>$page >  1 ? $page- 1 : -1,
            "page1"  =>$page+1,
            "page10"=>$page+10,
            "page100"=>$page+100,
            "page"=>$page,
            "etablissements"=>$etablissements));
    }

    #[Route('/etablissements/modifier', name: "selectFirstModifierEtablissement")]
    public function select_modifierFirst(): Response
    {
        return $this->redirect('/etablissements/modifier/1');
    }

    #[Route('/etablissements/inserer', name: "insererEtablissement")]
    public function inserer(Request $req): Response
    {
        return $this->modifier($req, -1);
    }
}
