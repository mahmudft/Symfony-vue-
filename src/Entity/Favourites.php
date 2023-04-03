<?php
namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
class Favourites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\OneToOne(targetEntity: Fruit::class)]
    #[ORM\JoinColumn(referencedColumnName: "id")]
    private Fruit $fruit;

    public function setId(int $id){
        $this->id = $id;
    }

    public function setFruit(Fruit $fruit){
        $this->fruit = $fruit;
    }

    public function getId(){
        return $this->id;
    }

    public function getFruit(){
        return $this->fruit;
    }
    
}
