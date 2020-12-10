<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^\w+/")
     */
    private $resume;

    /**
     * @ORM\Column(type="text")
     * @Assert\Regex("/^\w+/")
     */
    private $synopsis;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/i")
     */
    private $ad_sortie;

    /**
     * @ORM\Column(type="text")
     * @Assert\Url(
     *    protocols = {"http", "https"}
     * )
     */
    private $affiche;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $afficher = false;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="movies")
     */
    private $genre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->titre);
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getAdSortie(): ?string
    {
        return $this->ad_sortie;
    }

    public function setAdSortie(string $ad_sortie): self
    {
        $this->ad_sortie = $ad_sortie;

        return $this;
    }

    public function getAffiche(): ?string
    {
        return $this->affiche;
    }

    public function setAffiche(string $affiche): self
    {
        $this->affiche = $affiche;

        return $this;
    }

    public function getAfficher(): ?bool
    {
        return $this->afficher;
    }

    public function setAfficher(bool $afficher): self
    {
        $this->afficher = $afficher;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }
}
