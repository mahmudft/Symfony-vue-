<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;


#[ORM\Entity]
class Fruit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;    
    
    #[ORM\Column]
    private ?string $family = null;

    #[ORM\Column]
    private ?string $genus = null; 

     #[ORM\Column]
    private ?string $orderd = null;
    
    
    #[ORM\Column(type: Types::JSON)]
    private ?string $nutritions = null;

    
    
    public function getName(){
        return $this->name;
    }
    public function getFamily(){
        return $this->family;
    }
    public function getGenus(){
        return $this->genus;
    }
    public function getOrder(){
        return $this->orderd;
    }
    public function getNutritions(){
        return json_decode($this->nutritions);
    }

    public function getId(){
        return $this->id;
    }

    public function setName(string $name){
        $this->name = $name;
    }
    public function setFamily(string $family){
        $this->family = $family;
    }
    public function setGenus(string $genus){
        $this->genus = $genus;
    }
    public function setOrder(string $order){
        $this->orderd = $order;
    }
    public function setNutritions(string $nutritions){
        $this->nutritions = $nutritions;
    }

}
