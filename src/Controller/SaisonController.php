<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Serie;
use App\Entity\Saison;
use App\Form\SaisonType;

class SaisonController extends AbstractController
{
    protected $serieRepo;
    protected $saisonRepo;

    /**@var EntityManagerInterface $em */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->serieRepo = $entityManager->getRepository(Serie::class);
        $this->saisonRepo = $entityManager->getRepository(Saison::class);
    }

    /**
     * @Route("serie/{serieSlug}/saison-{saisonNumber}")
     */
    public function view($serieSlug, $saisonNumber)
    {

        $saison = $this->saisonRepo->getSaison($serieSlug, $saisonNumber);

        $data = array(
            'saison' => $saison,
            'serie' => $saison->getSerie(),
            'episodes' => $saison->getEpisodes()
        );

        return $this->render('Saison/view.html.twig', $data);
    }

    /**
     * @Route("/admin-old/{serieSlug}/saison-{saisonNumber}/edit")
     * @Route("/admin-old/{serieSlug}/saison/add", name="app_saison_add")
     */
    public function edit($serieSlug, $saisonNumber = null, Request $request)
    {
        $saison = $this->saisonRepo->getSaison($serieSlug, $saisonNumber);

        if(!$saison instanceof Saison){
            $serie = $this->serieRepo->findOneBy(array(
                'slug' => $serieSlug
            ));
            $saison = new Saison();
            $saison->setSerie($serie);
        }

        $form = $this->createForm(SaisonType::class, $saison);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $saison = $form->getData();

            $this->entityManager->persist($saison);
            $this->entityManager->flush();

            $this->addFlash(
                'info',
                'Your changes were saved!'
            );

            return $this->redirectToRoute('app_saison_edit', ['serieSlug' => $serieSlug, 'saisonNumber'=> $saison->getNumber()]);
        }

        $data = array(
            'saison' => $saison,
            'serie' => $saison->getSerie(),
            'form' => $form->createView(),
            'is_admin' => true
        );
        return $this->render('Saison/edit_saison.html.twig', $data);
    }
}

