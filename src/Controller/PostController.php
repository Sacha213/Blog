<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request;


class PostController extends AbstractController
{

    /**
     * @Route("/admin/post/{idPost}", name="post.show")
     */
    public function show($idPost)
    {

        // On récupère le `repository` en rapport avec l'entity `Post` 
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        // On fait appel à la méthode générique `find` qui permet de SELECT en fonction d'un Id
        $post = $postRepository->find($idPost);

        if (!$post) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id " . $idPost
            );
        }

        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/admin/post", name="post.list")
     */
    public function list()
    {
        // On récupère le `repository` en rapport avec l'entity `Post` 
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        // On fait appel à la méthode générique `findAll` qui permet de récupérer tout les posts
        $posts = $postRepository->findAll();

        if (!$posts) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé"
            );
        }

        return $this->render('post/list.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/admin/post/new/create", name="post.create")
     */
    public function create(Request $request)
    {
        // On crée un nouveau objet Post
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        //Récupère les données transmises par la requête pour les transmettre au formulaire
        $form->handleRequest($request);
        // Vérifie si le formulaire a été soumis et s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère l'objet `Post` qui a été passé au formulaire
            // L'objet `Post` a été mis à jour avec les données soumises et validées 
            $post = $form->getData();

            // On récupère le manager des entities
            $entityManager = $this->getDoctrine()->getManager();

            // On dit à Doctrine que l'on veut sauvegarder le Post
            // (Pas encore de requête faite en base)
            $entityManager->persist($post);

            // La/les requêtes sont exécutées (i.e. la requête INSERT) 
            $entityManager->flush();
        }

        return $this->render(
            'post/create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/admin/post/{idPost}/edit", name="post.edit")
     */
    public function edit($idPost, Request $request)
    {

        // On récupère le manager des entities
        $entityManager = $this->getDoctrine()->getManager();

        // On récupère le `repository` en rapport avec l'entity `Post`
        $postRepository = $entityManager->getRepository(Post::class);
        // On fait appel à la méthode générique `find` qui permet de SELECT en fonction d'un Id
        $post = $postRepository->find($idPost);

        if (!$post) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id " . $idPost
            );
        }

        $form = $this->createForm(PostType::class, $post);


        //Récupère les données transmises par la requête pour les transmettre au formulaire
        $form->handleRequest($request);
        // Vérifie si le formulaire a été soumis et s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère l'objet `Post` qui a été passé au formulaire
            // L'objet `Post` a été mis à jour avec les données soumises et validées 
            $post = $form->getData();

            // On dit à Doctrine que l'on veut sauvegarder le Post
            // (Pas encore de requête faite en base)
            $entityManager->persist($post);

            // On met à jour en base de données avec les valeurs modifiées (i.e. la requête UPDATE)
            $entityManager->flush();
        }


        return $this->render('post/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/post/{idPost}/remove", name="post.remove")
     */
    public function remove($idPost)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $postRepository = $entityManager->getRepository(Post::class);

        $post = $postRepository->find($idPost);

        if (!$post) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id " . $idPost
            );
        }
        // On dit au manager que l'on veux supprimer cet objet en base de données
        $entityManager->remove($post);
        // On met à jour en base de données en supprimant la ligne correspondante (i.e. la requête DELETE)
        $entityManager->flush();


        return $this->redirectToRoute('post.list');
    }

    /**
     * @Route("/", name="post.index")
     */
    public function index()
    {

        // On récupère le `repository` en rapport avec l'entity `Post` 
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        // On fait appel à la méthode générique `findAll` qui permet de récupérer tout les posts
        $posts = $postRepository->findAll();

        if (!$posts) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé"
            );
        }

        //On récupère la variable d'affichage de page
        if(isset($_GET['page'])){
            $page = $_GET['page'];
            
            if($page<0){
                $page=0;
            }
        }
        else{
            $page = 0;
        }

        return $this->render('post/index.html.twig', [
            'posts' => $posts, 'page'=> $page
        ]);
    }

    /**
     * @Route("/post/{idPost}", name="post.read")
     */
    public function read($idPost)
    {

        // On récupère le `repository` en rapport avec l'entity `Post` 
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        // On fait appel à la méthode générique `find` qui permet de SELECT en fonction d'un Id
        $post = $postRepository->find($idPost);

        if (!$post) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id " . $idPost
            );
        }

        return $this->render('post/read.html.twig', [
            'post' => $post
        ]);
    }

}
