<?php


namespace App\Entity;


use Doctrine\Common\Annotations\Annotation\Enum;
use JetBrains\PhpStorm\Pure;

class SecteurEnum
{
    public const PRIVEE = "Privée";
    public const PUBLIC = "Public";

    public static function values(): array
    {
        return array( self::PRIVEE,
            self::PUBLIC );
    }

    public static function assocValues(): array
    {
        return array( self::PRIVEE => self::PRIVEE,
            self::PUBLIC => self::PUBLIC );
    }

    #[Pure] public static function isSecteur(string $str ): bool
    {
        return array_search($str, self::values());
    }

    #[Pure] public static function get(string $str): string
    {
        return self::values()[array_search($str, self::values())];
    }
}