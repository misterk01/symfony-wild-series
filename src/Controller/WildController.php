<?php
// src/Controller/WildController.php
namespace App\Controller;


use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Category;
use App\Form\ProgramSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @Route("/wild", name="wild")
 */

class WildController extends AbstractController
{
    /**
     * @Route("", name="_index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException('No program found in program\s table.'
            );
        }
        $form = $this->createForm(ProgramSearchType::class,null,['method' => Request::METHOD_GET]
        );

        return $this->render('wild/index.html.twig',
            ['programs' => $programs,
             'form' => $form->createView(),
            ]
        );
    }

    /**
     * Getting a program with a formatted slug for title
     *
     * @param string $slug The slugger
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="_show")
     * @return Response
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' . $slug . ' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'programs' => $program,
            'slug' => $slug,
        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     * @Route("/category/{categoryName}", name="show_category")
     * @return Response
     */
    public function showByCategory(?string $categoryName): Response
    {
        if (!$categoryName) {
            throw $this->createNotFoundException('No category has been sent to find a program in program\'s table.');
        }
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);
        $categoryId = $category->getId();

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $categoryId], array('id' => 'desc'), 3, 0);


        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' . $categoryName . ' name, found in category\'s table.'
            );
        }

        return $this->render('wild/category.html.twig', [
            'category' => $categoryName,
            'programs' => $program
        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     * @Route("/program/{slug<^[a-z0-9-]+$>}", name="_program")
     * @return Response
     */
    public function showByProgram(?string $slug)
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' . $slug . ' title, found in program\'s table.'
            );
        }
        return $this->render('wild/showProgram.html.twig', [
            'program' => $program,
            'slug' => $slug,
        ]);
    }

    /**
     * Getting a program with a formatted slug for title
     * @Route("/season/{id}", name="_season")
     * @return Response
     */

    public function showBySeason(?int $id): Response
    {
        if (!$id) {
            throw $this->createNotFoundException('No category has been sent to find a program in program\'s table.');
        }
       $season = $this->getDoctrine()
           ->getRepository(Season::class)
           ->find(['id' => $id]);

        return $this->render('wild/showSeason.html.twig', [
            'season' => $season

        ]);
    }
    /**
     * Getting an episode with an id
     * @Route("/episode/{id}", name="_episode")
     * @return Response
     */
        public function showEpisode(Episode $episode): Response

        {$season = $episode->getSeason();
            return $this->render('wild/episode.html.twig', ['episode'=>$episode, 'season'=>$season, 'program'=>$season->getProgram()]);
        }

}
/*        return replace('/pratique/-+/', '-', $slug);
    }
/*    public function new(): Response
    {
        // traitement d'un formulaire par exemple

        // redirection vers la page 'wild_show', correspondant à l'url wild/show/5
        return $this->redirectToRoute('wild_show', ['slug'=> 1]);
    }
}
/* Créer une nouvelle série (via un formulaire en POST uniquement)
    @Route("/wild/new", methods={"POST"}, name="wild_new")
*/

/* Afficher une série en fonction de son identifiant
    @Route("/wild/{id}", methods={"GET"}, name="wild_show")
*/

/* Supprimer une série
    @Route("/wild/{id}", methods={"DELETE"}, name="wild_delete")
*/
