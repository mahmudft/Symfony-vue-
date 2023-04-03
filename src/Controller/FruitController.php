<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Fruit;

class FruitController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }
    #[Route('/fruits', name: 'fruits', methods:["GET"])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $fruits = $entityManager->getRepository(Fruit::class)->findAll();

        $data = [];
        foreach ($fruits as $fruit) {
            array_push($data, [
               'id' => $fruit->getId(),
               'name' => $fruit->getName(),
               'family' => $fruit->getFamily(),
               'genus' => $fruit->getGenus(),
               'order' => $fruit->getOrder(),
               'nutritions' => $fruit->getNutritions(),
            ]);
        }
        // return $this->json($data);
        // return new JsonResponse($this->serializer->serialize($data, JsonEncoder::FORMAT), 200, ['Content-Type' => 'application/json;charset=UTF-8']);
        return $this->json($data,  headers: ['Content-Type' => 'application/json;charset=UTF-8']);
    }
}
