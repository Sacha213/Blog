<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;


class PostController extends AbstractController
{

    /**
     * @Route("/admin/post/{idPost}")
     */
    public function show($idPost)
    {

        // On récupère le `repository` en rapport avec l'entity `Post` 
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        // On fait appel à la méthode générique `find` qui permet de SELECT en fonction d'un Id
        $post = $postRepository->find($idPost);

        if(!$post) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id ".$idPost
            );
        }

        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/admin/post")
     */
    public function list()
    {
        // On récupère le `repository` en rapport avec l'entity `Post` 
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        // On fait appel à la méthode générique `findAll` qui permet de récupérer tout les posts
        $posts = $postRepository->findAll();

        if(!$posts) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé"
            );
        }

        return $this->render('post/list.html.twig',[
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/admin/post/create")
     */
    public function create()
    {
         // On crée un nouveau objet Post
        $post = new Post();
        $post->setTitle('Mon titre');
        $post->setContent('Mon contenu');
        
        // On récupère le manager des entities
        $entityManager = $this->getDoctrine()->getManager();
        
        // On dit à Doctrine que l'on veut sauvegarder le Post
        // (Pas encore de requête faite en base)
        $entityManager->persist($post);
        
        // La/les requêtes sont exécutées (i.e. la requête INSERT) 
        $entityManager->flush();

        return $this->render('post/create.html.twig',[
            'post' => $post,
        ]
    );
    }

    /**
     * @Route("/admin/post/{idPost}/edit")
     */
    public function edit($idPost)
    {
        // On récupère le manager des entities
        $entityManager = $this->getDoctrine()->getManager();
        // On récupère le `repository` en rapport avec l'entity `Post`
        $postRepository = $entityManager->getRepository(Post::class);
        // On fait appel à la méthode générique `find` qui permet de SELECT en fonction d'un Id
        $post = $postRepository->find($idPost);

        if(!$post) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id ".$idPost
            );
        }
        // On modifie le contenu de l'objet Post
        $post->setContent('Mon contenu mis à jour');
        // On met à jour en base de données avec les valeurs modifiées (i.e. la requête UPDATE)
        $entityManager->flush();


        return $this->render('post/edit.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/admin/post/{idPost}/remove")
     */
    public function remove($idPost)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $postRepository = $entityManager->getRepository(Post::class);
    
        $post = $postRepository->find($idPost);
    
        if(!$post) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id ".$idPost
            );
        }
        // On dit au manager que l'on veux supprimer cet objet en base de données
        $entityManager->remove($post);
        // On met à jour en base de données en supprimant la ligne correspondante (i.e. la requête DELETE)
        $entityManager->flush();
    

        return $this->redirectToRoute('post.list');
    }
}
