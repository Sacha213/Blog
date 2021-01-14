<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;

class CategoryController extends AbstractController
{

    /**
     * @Route("/admin/category/{idCategory}")
     */
    public function show($idCategory)
    {
        // On récupère le `repository` en rapport avec l'entity `Category` 
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        // On fait appel à la méthode générique `find` qui permet de SELECT en fonction d'un Id
        $category = $categoryRepository->find($idCategory);

        if(!$category) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id ".$idCategory
            );
        }

        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @Route("/admin/category")
     */
    public function list()
    {
        // On récupère le `repository` en rapport avec l'entity `Category` 
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        // On fait appel à la méthode générique `findAll` qui permet de récupérer toutes les categories
        $categories = $categoryRepository->findAll();

        if(!$categories) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé"
            );
        }

        return $this->render('category/list.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/category/create")
     */
    public function create()
    {
        // On crée un nouveau objet Category
        $category = new Category();
        $category->setName("Manga");
        
        // On récupère le manager des entities
        $entityManager = $this->getDoctrine()->getManager();
        
        // On dit à Doctrine que l'on veut sauvegarder la Category
        // (Pas encore de requête faite en base)
        $entityManager->persist($category);
        
        // La/les requêtes sont exécutées (i.e. la requête INSERT) 
        $entityManager->flush();

        return $this->render('category/create.html.twig',[
            'category' => $category,
        ]);
    }

    /**
     * @Route("/admin/category/{idCategory}/edit")
     */
    public function edit($idCategory)
    {
        // On récupère le manager des entities
        $entityManager = $this->getDoctrine()->getManager();
        // On récupère le `repository` en rapport avec l'entity `Category`
        $categoryRepository = $entityManager->getRepository(Category::class);
        // On fait appel à la méthode générique `find` qui permet de SELECT en fonction d'un Id
        $category = $categoryRepository->find($idCategory);

        if(!$category) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id ".$idCategory
            );
        }
        // On modifie le contenu de l'objet Category
        $category->setName("Rap");
        // On met à jour en base de données avec les valeurs modifiées (i.e. la requête UPDATE)
        $entityManager->flush();

        return $this->render('category/edit.html.twig', [
            'category' => $category
        ]);
    }

    /**
     * @Route("/admin/category/{idCategory}/remove")
     */
    public function remove($idCategory)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categoryRepository = $entityManager->getRepository(Category::class);
    
        $category = $categoryRepository->find($idCategory);
    
        if(!$category) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id ".$idCategory
            );
        }
        // On dit au manager que l'on veux supprimer cet objet en base de données
        $entityManager->remove($category);
        // On met à jour en base de données en supprimant la ligne correspondante (i.e. la requête DELETE)
        $entityManager->flush();
    

        return $this->redirectToRoute('category.list');
    }
}
