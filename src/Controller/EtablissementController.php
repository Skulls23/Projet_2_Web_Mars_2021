<?php

namespace App\Controller;

use App\Entity\Etablissement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    #[Route('/etablissement', name: 'etablissement')]
    public function index(): Response
    {
        return $this->render('etablissement/index.html.twig', [
            'controller_name' => 'EtablissementController',
        ]);
    }

    #[Route('/lecture_csv', name: 'lecture_csv')]
    public function lecture_csv(): Response
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $sRet           = '';



        return new Response('Lecture réalisé sans echec, les retours sont:<br/>' . $sRet);
    }

    #[Route('/etablissement/vue/{page}', name: 'vue')]
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

        return new Response('Lecture réalisé sans echec, les retours sont:<br/>' . $sRet."</table>");
    }

    #[Route('/etablissement/supprimer', name: 'supprimer')]
    public function supprimer()
    {
        return new Response("Supprimer");
    }

    #[Route('/etablissement/modifier', name: 'modifier')]
    public function modifier()
    {
        return new Response("Modifier");
    }
}
