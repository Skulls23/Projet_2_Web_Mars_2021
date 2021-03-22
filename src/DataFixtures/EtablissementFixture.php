<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use App\Entity\SecteurEnum;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtablissementFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        gc_enable();

        $csvFile = fopen("./data/fr-en-adresse-et-geolocalisation-etablissements-premier-et-second-degre.csv", 'r');

        $i = 0;
        while( !feof($csvFile) )
        {
            $lines = fgetcsv($csvFile, 0, ';');

            if( $i > 0 && $lines ) // $lines == false si derniere ligne
            {
                $et = new Etablissement();

                $et->setUai                 ($lines[ 0]);
                $et->setAppellationOfficelle($lines[ 1]);
                $et->setDenomination        ($lines[ 2]);
                $et->setSecteur             (SecteurEnum::get($lines[ 4]));
                $et->setAdresse             ($lines[ 5]);
                $et->setCodePostal          (intval($lines[ 8]));
                $et->setCommune             ($lines[10]);
                $et->setLatitude            (floatval($lines[14]));
                $et->setLongitude           (floatval($lines[15]));
                $et->setCodeDepartement     ($lines[22]);
                $et->setDepartement         ($lines[26]);
                $et->setRegion              ($lines[27]);
                $et->setAcademie            ($lines[28]);
                $et->setDateOuverture       (DateTime::createFromFormat("Y-m-j", $lines[34]));

                $manager->persist($et);
            }

            if( ($i++ % 100) == 0)
            {
                $manager->flush();

                $manager->clear();
                gc_collect_cycles();
            }
        }

        $manager->flush();
    }
}
