<?php

namespace App\Controller;

use App\Entity\Etablissement;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouteCollection;

class EtablissementController extends AbstractController
{
    #[Route('/etablissements', name: 'etablissement')]
    public function index(): Response
    {
        return $this->render('etablissement/index.html.twig', [
            'controller_name' => 'EtablissementController',
        ]);
    }

    #[Route('/etablissements/vue', name: 'getVueSansPage')]
    public function getVueSansPage(): Response
    {
        return $this->redirect('/etablissements/vue/1');
    }

    #[Route('/etablissements/vue/{page}', name: 'getVue')]
    public function getVue(int $page): Response
    {
        if( $page == 0 ) $page = 1;

        $page = abs($page);

        $manager        = $this->getDoctrine()->getManager()->getRepository(Etablissement::class);
        $etablissements = $manager->findBy(array(), orderBy: array("id" => "ASC"), limit: 500, offset: ($page-1)*500);

        $i = 0;
        $sRet = "<table>";
        foreach ($etablissements as $etablissement)
            $sRet .= "<tr><td>" . ($i++ +1) . "</td><td>" . $etablissement->getId() . "</td><td>" . $etablissement->getUai() . "</td><td>" . $etablissement->getAppellationOfficelle() . "</td></tr>";

        return new Response('Lecture réalisé sans echec, les retours sont:<br/><br/>' . $sRet."</table>");
    }

    #[Route('/etablissements/supprimer', name: "supprimer")]
    public function supprimer(): Response
    {
        return new Response("supprimer vide");
    }

    #[Route('/etablissements/modifier', name: "modifier")]
    public function modifier(): Response
    {
        return new Response("modifier vide");
    }
}
