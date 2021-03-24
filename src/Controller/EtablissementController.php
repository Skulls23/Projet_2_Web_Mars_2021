<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Form\EtablissementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        $i = 0;
        $sRet = "<table>";
        foreach ($etablissements as $etablissement)
            $sRet .= "<tr><td>" . ($i++ +1) . "</td><td>" . $etablissement->getId() . "</td><td>" . $etablissement->getUai() . "</td><td>" . $etablissement->getAppellationOfficelle() . "</td></tr>";

        return new Response('Lecture réalisé sans echec, les retours sont:<br/><br/>' . $sRet."</table>");
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
    public function modifier( int $id ): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $reposit = $manager->getRepository(Etablissement::class);

        $et = $reposit->find($id);

        $type = new EtablissementType();
        $form = $this->createFormBuilder($et);

        $type->buildForm($form, array());

        return $this->render('etablissement/modifier/modifier.html.twig', array("form" => $form->getForm()->createView()));
    }

    #[Route('/etablissements/inserer', name: "insererEtablissement")]
    public function inserer(): Response
    {
        return $this->render('etablissement/inserer/inserer.html.twig', array("message" => "Création d'un établissement"));
    }
}
