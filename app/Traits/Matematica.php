<?php 

namespace App\Traits;


trait Matematica 
{

  public function adicionar($par1, $par2)
  {

    return $par1 + $par2;

  }

  public function seno($angulo)
  {

    return sin($angulo);

  }

}