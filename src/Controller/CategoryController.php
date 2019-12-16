<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("wild/category/add", name="category")
     */
    public function add(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

               if ($form->isSubmitted() && $form->isValid()) {

                   $em = $this->getDoctrine()->getManager();
                   $em->persist($category);
                   $em->flush();

               }

        return $this->render('wild/newCategory.html.twig', [
            'category_form' => $form->createView()
        ]);
    }
}
