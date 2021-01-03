<?php

namespace App\Controller\API;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SerieController
 * @package App\Controller\API
 * @Route("/api/series")
 */
class SerieController extends AbstractController
{
    private $serieRepository;
    private $jms_serializer;

    public function __construct(SerializerInterface $jms_serializer, SerieRepository $serieRepository)
    {
        $this->serieRepository = $serieRepository;
        $this->jms_serializer = $jms_serializer;
    }

    /**
     * @Route("/all")
     */
    public function all() :Response
    {
        $series = $this->serieRepository->findAll();

        $data = $this->jms_serializer
            ->serialize($series, 'json', SerializationContext::create()->setGroups(['list']));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/{id<\d+>}")
     * @param $id
     * @return JsonResponse
     */
    public function getById($id): Response
    {
        $serie = $this->serieRepository->getDetailsSerie($id);

        $data = $this->jms_serializer
            ->serialize($serie, 'json', SerializationContext::create()->setGroups(['detail']));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/search")
     */
    public function search(): JsonResponse
    {
        return $this->json([]);
    }
}