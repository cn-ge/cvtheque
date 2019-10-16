<?php

namespace App\Entity;


class CandidatSearch
{
  /*
   * @var string|null
   * */
  private $cp;

  /*
   * @var string|null
   * */
  private $nom;



  public function getCp(): ?string
  {
      return $this->cp;
  }

  public function setCp(string $cp): CandidatSearch
  {
      $this->cp = $cp;
      return $this;
  }

  public function getNom(): ?string
  {
      return $this->nom;
  }

  public function setNom(string $nom): CandidatSearch
  {
      $this->nom = $nom;
      return $this;
  }

}