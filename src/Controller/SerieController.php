<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use App\Entity\Serie;
use App\Form\SerieType;

class SerieController extends AbstractController
{
    protected $serieRepo;

    /**@var EntityManagerInterface $em */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->serieRepo = $entityManager->getRepository(Serie::class);
        $this->entityManager = $entityManager;
    }

    public function menu($is_admin = false)
    {

        $series = $this->serieRepo->getMenu();

        $data = array('series' => $series, 'is_admin' => $is_admin);

        return $this->render('Layout/menu.html.twig', $data);
    }

    /**
     * @Route("serie/{serieSlug}")
     * @param string $serieSlug
     * @return Response
     */
    public function view($serieSlug)
    {
        try{

            $serie = $this->serieRepo
                ->getSerieWithSaisons($serieSlug)
            ;

        }catch(NonUniqueResultException $e){
            $serie = array();
        }

        $data = array(
            'serie' => $serie,
        );

        return $this->render("Serie/view.html.twig", $data);
    }

    /**
     * @Route("/admin-old/{serieSlug}")
     * @param string $serieSlug
     * @return Response
     */
    public function edit($serieSlug, Request $request)
    {
        try{

            $serie = $this->serieRepo
            ->getSerieWithSaisons($serieSlug)
            ;

        }catch(NonUniqueResultException $e){
            $serie = array();
        }

        $form = $this->createForm(SerieType::class, $serie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $serie = $form->getData();

            $this->entityManager->persist($serie);
            $this->entityManager->flush();
        }

        $data = array(
            'serie' => $serie,
            'form' => $form->createView(),
            'is_admin' => true
        );

        return $this->render('Serie/edit_serie.html.twig', $data);
    }
}
