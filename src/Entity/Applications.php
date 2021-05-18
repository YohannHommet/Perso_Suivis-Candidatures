<?php

namespace App\Entity;

use App\Repository\ApplicationsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApplicationsRepository::class)
 */
class Applications
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nom_entreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $localisation_entreprise;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $poste_recherche;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $nature_candidature;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $date_candidature;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $lien_candidature;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $email_contact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $technos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $remarques;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nom_entreprise;
    }

    public function setNomEntreprise(string $nom_entreprise): self
    {
        $this->nom_entreprise = $nom_entreprise;

        return $this;
    }

    public function getLocalisationEntreprise(): ?string
    {
        return $this->localisation_entreprise;
    }

    public function setLocalisationEntreprise(string $localisation_entreprise): self
    {
        $this->localisation_entreprise = $localisation_entreprise;

        return $this;
    }

    public function getPosteRecherche(): ?string
    {
        return $this->poste_recherche;
    }

    public function setPosteRecherche(string $poste_recherche): self
    {
        $this->poste_recherche = $poste_recherche;

        return $this;
    }

    public function getNatureCandidature(): ?string
    {
        return $this->nature_candidature;
    }

    public function setNatureCandidature(string $nature_candidature): self
    {
        $this->nature_candidature = $nature_candidature;

        return $this;
    }

    public function getDateCandidature(): ?\DateTimeInterface
    {
        return $this->date_candidature;
    }

    public function setDateCandidature(\DateTimeInterface $date_candidature): self
    {
        $now = date('d/m/Y');
        $this->date_candidature = new DateTime($now);

        return $this;
    }

    public function getLienCandidature(): ?string
    {
        return $this->lien_candidature;
    }

    public function setLienCandidature(string $lien_candidature): self
    {
        $this->lien_candidature = $lien_candidature;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->email_contact;
    }

    public function setEmailContact(?string $email_contact): self
    {
        $this->email_contact = $email_contact;

        return $this;
    }

    public function getTechnos(): ?string
    {
        return $this->technos;
    }

    public function setTechnos(string $technos): self
    {
        $this->technos = $technos;

        return $this;
    }

    public function getRemarques(): ?string
    {
        return $this->remarques;
    }

    public function setRemarques(?string $remarques): self
    {
        $this->remarques = $remarques;

        return $this;
    }
}
