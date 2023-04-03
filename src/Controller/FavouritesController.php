<?php
namespace App\Controller;

use App\Entity\Favourites;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Fruit;

class FavouritesController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer, private EntityManagerInterface $entityManager)
    {
    }
    #[Route('/favourites', name: 'favourites', methods:["GET"])]
    public function index(): JsonResponse
    {
        $favourites = $this->entityManager->getRepository(Favourites::class)->findAll();

        $data = [];
        foreach ($favourites as $fav) {
            array_push($data, [
               'id' => $fav->getId(),
               'fruit'=> $fav->getFruit(),
            ]);
        }
    
        return $this->json($data, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
    }

    #[Route('/favourites/{id}', name: 'favourites_id', methods:["POST"])]
    public function addFavourite(int $id): JsonResponse
    {
        $repositary = $this->entityManager->getRepository(Fruit::class);
        $favourite = $this->entityManager->getRepository(Favourites::class);
        $fruit = $repositary->findOneBy(['id'=>$id]);


        $totalcount = count($favourite->findAll());
        $entity = $favourite->findOneBy(['fruit' => $id]);
        try {
            if ($entity) {
                throw new HttpException(400, 'Fruit already added to favourite\'s list');
            //   return $this->json('Fav Fruit already added', 500, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
            } elseif ($totalcount > 10) {
                throw new HttpException(400, 'Headcount have reached. You can not added more than 10 fruits');

                // return $this->json('Headcount have reached', 500, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
            } else {
                $favourite = new Favourites();
                $favourite->setFruit($fruit);
                $this->entityManager->persist($favourite);
                $this->entityManager->flush();

                return $this->json('Added new Entity with Id: '.$favourite->getId(), 200, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
            }
        } catch(HttpException $error) {
            return $this->json($error->getMessage(), 400, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
        }
    }
}
