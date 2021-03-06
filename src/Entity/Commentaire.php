<?php

namespace App\Entity;

use DateTimeInterface;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=50)
     */
    private $auteur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     *  @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      notInRangeMessage = "A note value must be within  {{ min }} and {{ max }} degrees",
     * )
     *
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=500)
     */
    private $texte;

    /**
     * @ORM\ManyToOne(targetEntity=Etablissement::class, inversedBy="commentaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $uai;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getDateCreation(): ?DateTimeInterface
    {
        return $this->date_creation;
    }

    public function getDateString(): ?string
    {
        if($this->getDateCreation() != null)
            return $this->getDateCreation()->format("d-m-Y");
        return null;
    }

    public function setDateCreation(DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getEtablissement(): ?Etablissement
    {
        return $this->uai;
    }

    public function setEtablissement(?Etablissement $uai): self
    {
        $this->uai = $uai;

        return $this;
    }
}
