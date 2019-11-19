<?php
// src/Controller/WildController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class WildController extends AbstractController
{
    /**
     * @Route("/wild", name="wild_index")
     */
    public function index(): Response
    {
        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }

    /**
     * @Route("/wild/show/{slug}", requirements={"slug" ="[a-z0-9-]+"}, defaults={"slug" = "Aucune série sélectionnée, veuillez choisir une série"}, name="wild_show")
     */
    public function show(string $slug): Response
    {

        $replace = str_replace('-', ' ',$slug);
        $ucWords = ucwords($replace);
        return $this->render('wild/show.html.twig', ['slug' => $ucWords]);
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
