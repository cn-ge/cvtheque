<?php

namespace App\Entity;


class UserSearch
{
  /*
   * @var string|null
   */
  private $cp;

  /*
   * @var string|null
   */
  private $nom;



  public function getCp(): ?string
  {
      return $this->cp;
  }

  public function setCp(string $cp): UserSearch
  {
      $this->cp = $cp;
      return $this;
  }

  public function getNom(): ?string
  {
      return $this->nom;
  }

  public function setNom(string $nom): UserSearch
  {
      $this->nom = $nom;
      return $this;
  }

}