<?php

namespace App\Controller\API;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
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
     * @Rest\Get("/all")
     * @Rest\View(serializerGroups={"list"})
     * @OA\Tag(name="Series")
     * @OA\Response(
     *     response="200",
     *     description="Return all series",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Serie_light"))
     * )
     * )
     * @OA\Response(
     *     response="default",
     *     description="Unexpected error",
     *     @OA\JsonContent(
     *          ref="#/components/schemas/Error"
     *      )
     * )
     * @return Serie[]
     */
    public function all(): array
    {
        return $this->serieRepository->findAll();

        /*$data = $this->jms_serializer
            ->serialize($series, 'json', SerializationContext::create()->setGroups(['list']));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;*/
    }

    /**
     * @Rest\Get("/{id<\d+>}")
     * @Rest\View(serializerGroups={"detail"})
     * @OA\Tag(name="Series")
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Id of the serie",
     *     @OA\Schema(type="string",format="int32")
     * )
     * @OA\Response(
     *     response=200,
     *     description="Details about a serie",
     *     @OA\JsonContent(
     *          ref="#/components/schemas/Serie"
     *     )
     * )
     * @OA\Response(
     *     response="default",
     *     description="Unexpected error",
     *     @OA\JsonContent(
     *          ref="#/components/schemas/Error"
     *      )
     * )
     * @param $id
     * @return Serie
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getById($id): Serie
    {
        return $this->serieRepository->getDetailsSerie($id);

        /*$data = $this->jms_serializer
            ->serialize($serie, 'json', SerializationContext::create()->setGroups(['detail']));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;*/
    }

    /**
     * @Rest\Post("/search")
     * @OA\Tag(name="Series")
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/x-www-form-urlencoded",
     *          @OA\Schema(
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="code", type="string")
     *          )
     *      )
     * )
     * @OA\Response(
     *     response="200",
     *     description="Search serie",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Serie_light"))
     *      )
     * )
     * @OA\Response(
     *     response="default",
     *     description="Unexpected error",
     *     @OA\JsonContent(
     *          ref="#/components/schemas/Error"
     *      )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $parameters = $request->request->all();
        return $this->json([]);
    }
}