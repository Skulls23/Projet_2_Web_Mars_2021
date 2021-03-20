<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtablissementFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);
        // $product = new Product();
        // $manager->persist($product);
        gc_enable();

        $csv = fopen("data/fr-en-adresse-et-geolocalisation-etablissements-premier-et-second-degre.csv", "r");

        $i = 0;
        while(! feof($csv))
        {
            $donnees = fgetcsv($csv, 0, ";"); //taille 0 = taille infinie
            if($i > 0 && $donnees) //donnees renvoie false si on est a la derniere ligne
            {
                $etablissement = new Etablissement();

                $etablissement->setUai                 ($donnees[0]);
                $etablissement->setAppellationOfficelle($donnees[1]);
                $etablissement->setDenomination        ($donnees[2]);
                $etablissement->setSecteur             ($donnees[4]);
                $etablissement->setLatitude            (floatval($donnees[14]));
                $etablissement->setLongitude           (floatval($donnees[15]));
                $etablissement->setAdresse             ($donnees[5]);
                $etablissement->setDepartement         ($donnees[26]);
                $etablissement->setCodeDepartement     (intval($donnees[22]));
                $etablissement->setCommune             ($donnees[10]);
                $etablissement->setRegion              ($donnees[27]);
                $etablissement->setAcademie            ($donnees[28]);
                $etablissement->setCodePostal          (intval($donnees[7]));
                $etablissement->setDateOuverture       (DateTime::createFromFormat("Y-m-d", $donnees[34]));

                $manager->persist($etablissement);
            }

            if($i % 100 == 0) {
                $manager->flush();
                $manager->clear();
                gc_collect_cycles();
            }

            $i++;
        }

        $manager->flush();
    }
}
