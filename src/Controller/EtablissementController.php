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

    #[Route('/etablissement/vueEtablissement/{numPage}', name: 'vueEtablissement')]
    public function getVueEtablissement(int $numPage): Response
    {
        $entity_manager = $this->getDoctrine()->getManager();
        $tabEtablissement = $entity_manager->getRepository(Etablissement::class)->findBy(array(), orderBy: array("id" => "ASC"), limit: 500, offset: ($numPage-1)*500);
        $sRet = "";
        foreach ($tabEtablissement as $etablissement)
        {
            $sRet .= $etablissement->getAppellationOfficelle()."<br>";
        }
        return new Response($sRet);
    }
}
