<?php

namespace App\Controller;

use App\Entity\Etablissement;
use DateTime;
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

        $csvFile = fopen("./data/fr-en-adresse-et-geolocalisation-etablissements-premier-et-second-degre.csv", 'r+');

        $i = 0;
        while(! feof($csvFile) )
        {
            $lines = fgetcsv($csvFile, 0, ';');

            if( $i > 0 && $lines ) // $lines == false si derniere ligne
            {
                $et = new Etablissement();

                $et->setUai                 ($lines[ 0]);
                $et->setAppellationOfficelle($lines[ 1]);
                $et->setDenomination        ($lines[ 2]);
                $et->setSecteur             ($lines[ 4]);
                $et->setAdresse             ($lines[ 5]);
                $et->setCodePostal          (intval($lines[ 7]));
                $et->setCommune             ($lines[10]);
                $et->setLatitude            (floatval($lines[14]));
                $et->setLongitude           (floatval($lines[15]));
                $et->setCodeDepartement     (intval($lines[22]));
                $et->setDepartement         ($lines[26]);
                $et->setRegion              ($lines[27]);
                $et->setAcademie            ($lines[28]);
                $et->setDateOuverture       (DateTime::createFromFormat("Y/m/j", $lines[34]));

                $sRet .= $et->getUai() . " " . $et->getAppellationOfficelle() . "<br/>";

                $entity_manager->persist($et);
            }

            if( $i > 0 && $i++ % 1000 == 0)
                $entity_manager->flush();
        }

        return new Response('Lecture réalisé sans echec, les retours sont:<br/>' . $sRet);
    }
}
