<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategoryType;

class CategoryController extends AbstractController
{

    /**
     * @Route("/admin/category/{idCategory}", name="category.show")
     */
    public function show($idCategory)
    {
        // On récupère le `repository` en rapport avec l'entity `Category` 
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        // On fait appel à la méthode générique `find` qui permet de SELECT en fonction d'un Id
        $category = $categoryRepository->find($idCategory);

        if(!$category) {
            throw $this->createNotFoundException(
                "Pas de Category trouvé avec l'id ".$idCategory
            );
        }

        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @Route("/admin/category", name="category.list")
     */
    public function list()
    {
        // On récupère le `repository` en rapport avec l'entity `Category` 
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        // On fait appel à la méthode générique `findAll` qui permet de récupérer toutes les categories
        $categories = $categoryRepository->findAll();

        if(!$categories) {
            throw $this->createNotFoundException(
                "Pas de Category trouvé"
            );
        }

        return $this->render('category/list.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/category/new/create", name="category.create")
     */
    public function create(Request $request)
    {

        // On crée un nouveau objet Post
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        //Récupère les données transmises par la requête pour les transmettre au formulaire
        $form->handleRequest($request);
        // Vérifie si le formulaire a été soumis et s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère l'objet `Post` qui a été passé au formulaire
            // L'objet `Post` a été mis à jour avec les données soumises et validées 
            $category = $form->getData();

            // On récupère le manager des entities
            $entityManager = $this->getDoctrine()->getManager();

            // On dit à Doctrine que l'on veut sauvegarder le Post
            // (Pas encore de requête faite en base)
            $entityManager->persist($category);

            // La/les requêtes sont exécutées (i.e. la requête INSERT) 
            $entityManager->flush();
        }

        return $this->render(
            'category/create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/admin/category/{idCategory}/edit", name="category.edit")
     */
    public function edit($idCategory, Request $request)
    {
        // On récupère le manager des entities
        $entityManager = $this->getDoctrine()->getManager();
        // On récupère le `repository` en rapport avec l'entity `Category`
        $categoryRepository = $entityManager->getRepository(Category::class);
        // On fait appel à la méthode générique `find` qui permet de SELECT en fonction d'un Id
        $category = $categoryRepository->find($idCategory);

        if(!$category) {
            throw $this->createNotFoundException(
                "Pas de Category trouvé avec l'id ".$idCategory
            );
        }
        
        $form = $this->createForm(CategoryType::class, $category);

        //Récupère les données transmises par la requête pour les transmettre au formulaire
        $form->handleRequest($request);
        // Vérifie si le formulaire a été soumis et s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère l'objet `Post` qui a été passé au formulaire
            // L'objet `Post` a été mis à jour avec les données soumises et validées 
            $category = $form->getData();

            // On récupère le manager des entities
            $entityManager = $this->getDoctrine()->getManager();

            // On dit à Doctrine que l'on veut sauvegarder le Post
            // (Pas encore de requête faite en base)
            $entityManager->persist($category);

            // La/les requêtes sont exécutées (i.e. la requête INSERT) 
            $entityManager->flush();
        }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/category/{idCategory}/remove", name="category.remove")
     */
    public function remove($idCategory)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categoryRepository = $entityManager->getRepository(Category::class);
    
        $category = $categoryRepository->find($idCategory);
    
        if(!$category) {
            throw $this->createNotFoundException(
                "Pas de Category trouvé avec l'id ".$idCategory
            );
        }
        // On dit au manager que l'on veux supprimer cet objet en base de données
        $entityManager->remove($category);
        // On met à jour en base de données en supprimant la ligne correspondante (i.e. la requête DELETE)
        $entityManager->flush();
    

        return $this->redirectToRoute('category.list');
    }
}
