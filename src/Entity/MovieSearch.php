<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class MovieSearch
{
    /**
     * Propriété rechercheNom.
     *
     * @Assert\Regex("/^\w+/")
     * @Assert\Length(min=2, max=155)
     *
     * @var string|null
     */
    private $rechercherNom;

    /**
     * Getter pour RechercheNom.
     *
     * @return string|null
     */
    public function getRechercherNom(): ?string
    {
        return $this->rechercherNom;
    }

    /**
     * Setters pour RechercheNom.
     *
     * @return MovieSearch
     */
    public function setRechercherNom(string $rechercherNom): MovieSearch
    {
        $this->rechercherNom = $rechercherNom;

        return $this;
    }

    //private $maVariableDeRecherche;
    //
    //annoté les variable avec un var int(ou autre type)|null
    //private $maVariableDeRechercheDeux;
    //créer les getter et setter des variables
    //public function getMaVariableDeRecherche(): ?type
    // { return $this->maVariableDeRecherche;}
    //public function setMaVariableDeRecherche(type $maVariableDeRecherche): MovieSearch (si on utilise le setter le type sera forcément définie)
    // { $this->maVariableDeRecherche = $maVariableDeRecherche;
    //   return $this;}
}
