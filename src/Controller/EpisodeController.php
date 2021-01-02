<?php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Serie;
use App\Entity\Saison;
use App\Form\EpisodeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EpisodeController extends AbstractController
{
	protected $serieRepo;
    protected $saisonRepo;
    protected $episodeRepo;

    /**@var EntityManagerInterface $em */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->serieRepo = $entityManager->getRepository(Serie::class);
        $this->saisonRepo = $entityManager->getRepository(Saison::class);
        $this->episodeRepo = $entityManager->getRepository(Episode::class);
    }

    /**
     * @Route("serie/{serieSlug}/saison-{saisonNumber}/{episodeNumber}")
     */
    public function view($serieSlug, $saisonNumber, $episodeNumber)
    {
    	$serie = $this->serieRepo->findOneBy(array(
            'slug' => $serieSlug
        ));

        $saison = $this->saisonRepo->findOneBy(array(
            'number' => $saisonNumber,
            'serie' => $serie
        ));

    	$episode = $this->episodeRepo->findOneBy(array(
    		'number' => $episodeNumber,
    		'saison' => $saison
    	));

    	$data = array(
    		'episode' => $episode,
            'saison' => $saison,
            'serie' => $serie
        );

        return $this->render('Episode/view.html.twig', $data);
    }

    /**
     * @Route("/admin-old/{serieSlug}/saison-{saisonNumber}/{episodeNumber}/edit")
     * @Route("/admin-old/{serieSlug}/saison-{saisonNumber}/add", name="app_episode_add")
     */
    public function edit($serieSlug, $saisonNumber, $episodeNumber = null, Request $request)
    {
    	$serie = $this->serieRepo->findOneBy(array(
            'slug' => $serieSlug
        ));

        $saison = $this->saisonRepo->findOneBy(array(
            'number' => $saisonNumber,
            'serie' => $serie
        ));

    	$episode = $this->episodeRepo->findOneBy(array(
    		'number' => $episodeNumber,
    		'saison' => $saison
    	));

    	if(!$episode instanceof Episode){
            $episode = new Episode();
            $episode->setSaison($saison);
        }

        $form = $this->createForm(EpisodeType::class, $episode, array('serie' => $serie));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $episode = $form->getData();

            $saison = $episode->getSaison();

            try{
                $this->entityManager->persist($episode);
                $this->entityManager->flush();

                $this->addFlash(
                    'info',
                    'Your changes were saved!'
                );

                return $this->redirectToRoute('app_episode_edit', ['serieSlug' => $serie->getSlug(), 'saisonNumber'=> $saison->getNumber(), 'episodeNumber' => $episode->getNumber()]);

            }catch(\Exception $e){
                $this->addFlash(
                    'danger',
                    $e->getMessage()
                );
            }
        }

    	$data = array(
    		'episode' => $episode,
            'saison' => $saison,
            'serie' => $serie,
            'form' => $form->createView(),
            'is_admin' => true
        );

    	return $this->render('Episode/edit_episode.html.twig', $data);
    }
}
