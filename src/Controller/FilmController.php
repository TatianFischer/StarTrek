<?php


namespace App\Controller;


use App\Entity\Film;
use App\Entity\Serie;
use App\Form\FilmType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    private $entityManager;
    private $filmRepo;
    private $serieRepo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->filmRepo = $entityManager->getRepository(Film::class);
        $this->serieRepo = $entityManager->getRepository(Serie::class);
    }

    /**
     * @Route("/film/{serieSlug}")
     * @param $serieSlug
     * @return Response
     */
    public function list($serieSlug)
    {
        $serie = $this->serieRepo->getSerieWithFilms($serieSlug);

        $data = array('serie' => $serie);

        return $this->render('Films/list.html.twig', $data);
    }

    /**
     * @Route("/film/{serieSlug}/{filmSlug}")
     * @param $serieSlug
     * @param $filmSlug
     * @return Response
     */
    public function details($serieSlug, $filmSlug)
    {
        $film = $this->filmRepo->findOneBy(array(
            'slug' => $filmSlug
        ));

        $serie = $this->serieRepo->findOneBy(array(
            'slug' => $serieSlug
        ));

        $data = array(
            'serie' => $serie,
            'film' => $film
        );

        return $this->render('Films/details.html.twig', $data);
    }

    /**
     * @Route("/admin-old/{serieSlug}/film-{filmSlug}/edit")
     * @Route("/admin-old/{serieSlug}/film/add", name="app_film_add")
     */
    public function edit($serieSlug, $filmSlug = null, Request $request)
    {
        $film = $this->filmRepo->getFilm($serieSlug, $filmSlug);


        if(!$film instanceof Film){
            $serie = $this->serieRepo->findOneBy(array(
                'slug' => $serieSlug
            ));

            $film = new Film();
            $film->setSerie($serie);
        }

        $form = $this->createForm(FilmType::class, $film);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $film = $form->getData();

            $this->entityManager->persist($film);
            $this->entityManager->flush();

            $this->addFlash(
                'info',
                'Your changes were saved!'
            );

            return $this->redirectToRoute('app_film_edit', ['serieSlug' => $serieSlug, 'filmSlug'=> $film->getSlug()]);
        }

        $data = array(
            'film' => $film,
            'serie' => $film->getSerie(),
            'form' => $form->createView(),
            'is_admin' => true
        );

        return $this->render('Films/edit.html.twig', $data);
    }
}
