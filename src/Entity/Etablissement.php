<?php

namespace App\Entity;

use App\Repository\EtablissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EtablissementRepository::class)
 */
class Etablissement
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
     * @ORM\Column(type="string", length=255)
     */
    private $uai;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=512)
     */
    private $appellation_officelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $denomination;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string")
     */
    private $secteur;

    /**
     * @Assert\Range(
     *      min = -90,
     *      max = 90,
     *      notInRangeMessage = "A latitude value must be within  {{ min }} and {{ max }} degrees",
     * )
     *
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @Assert\Range(
     *      min = -180,
     *      max = 180,
     *      notInRangeMessage = "A longitude value must be within  {{ min }} and {{ max }} degrees",
     * )
     *
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="string", length=1024)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $departement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code_departement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commune;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $academie;

    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 100000,
     *      notInRangeMessage = "value must be within  {{ min }} and {{ max }} !",
     * )
     *
     * @ORM\Column(type="integer")
     */
    private $code_postal;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="date")
     */
    private $date_ouverture;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="uai", orphanRemoval=true)
     */
    private $commentaire;

    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 500000,
     *      notInRangeMessage = "A value must be within  {{ min }} and {{ max }} !",
     * )
     *
     * @ORM\Column(type="integer")
     */
    private $code_commune;

    public function __construct()
    {
        $this->commentaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUai(): ?string
    {
        return $this->uai;
    }

    public function setUai(string $uai): self
    {
        $this->uai = $uai;

        return $this;
    }

    public function getAppellationOfficelle(): ?string
    {
        return $this->appellation_officelle;
    }

    public function setAppellationOfficelle(string $appellation_officelle): self
    {
        $this->appellation_officelle = $appellation_officelle;

        return $this;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getCodeDepartement(): ?string
    {
        return $this->code_departement;
    }

    public function setCodeDepartement(string $code_departement): self
    {
        $this->code_departement = $code_departement;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(string $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getAcademie(): ?string
    {
        return $this->academie;
    }

    public function setAcademie(string $academie): self
    {
        $this->academie = $academie;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->date_ouverture;
    }

    public function setDateOuverture(\DateTimeInterface $date_ouverture): self
    {
        $this->date_ouverture = $date_ouverture;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire[] = $commentaire;
            $commentaire->setEtablissement($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getEtablissement() === $this) {
                $commentaire->setEtablissement(null);
            }
        }

        return $this;
    }

    public function getCodeCommune(): ?int
    {
        return $this->code_commune;
    }

    public function setCodeCommune(int $code_commune): self
    {
        $this->code_commune = $code_commune;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getAppellationOfficelle();
    }
}
