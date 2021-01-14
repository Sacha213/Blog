<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;

class CommentController extends AbstractController
{

    /**
     * @Route("/admin/comment/{idComment}")
     */
    public function show($idComment)
    {

        // On récupère le `repository` en rapport avec l'entity `Comment` 
        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);
        // On fait appel à la méthode générique `find` qui permet de SELECT en fonction d'un Id
        $comment = $commentRepository->find($idComment);

        if(!$comment) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id ".$idComment
            );
        }

        return $this->render('comment/show.html.twig', [
            'comment' => $comment
        ]);
    }

    /**
     * @Route("/admin/comment")
     */
    public function list()
    {
        // On récupère le `repository` en rapport avec l'entity `Comment` 
        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);
        // On fait appel à la méthode générique `findAll` qui permet de récupérer tout les comments
        $comments = $commentRepository->findAll();

        if(!$comments) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé"
            );
        }

        return $this->render('comment/list.html.twig',[
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/admin/comment/create")
     */
    public function create()
    {
         // On crée un nouveau objet Comment
         $comment = new Comment();
         $comment->setUsername("Sacha");
         $comment->setContent('Mon contenu');
         
         // On récupère le manager des entities
         $entityManager = $this->getDoctrine()->getManager();
         
         // On dit à Doctrine que l'on veut sauvegarder le Comment
         // (Pas encore de requête faite en base)
         $entityManager->persist($comment);
         
         // La/les requêtes sont exécutées (i.e. la requête INSERT) 
         $entityManager->flush();

        return $this->render('comment/create.html.twig',[
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/admin/comment/{idComment}/edit")
     */
    public function edit($idComment)
    {
        // On récupère le manager des entities
        $entityManager = $this->getDoctrine()->getManager();
        // On récupère le `repository` en rapport avec l'entity `Comment`
        $commentRepository = $entityManager->getRepository(Comment::class);
        // On fait appel à la méthode générique `find` qui permet de SELECT en fonction d'un Id
        $comment = $commentRepository->find($idComment);

        if(!$comment) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id ".$idComment
            );
        }
        // On modifie le contenu de l'objet Comment
        $comment->setContent('Mon contenu mis à jour');
        // On met à jour en base de données avec les valeurs modifiées (i.e. la requête UPDATE)
        $entityManager->flush();

        return $this->render('comment/edit.html.twig', [
            'comment' => $comment
        ]);
    }

    /**
     * @Route("/admin/comment/{idComment}/remove")
     */
    public function remove($idComment)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $commentRepository = $entityManager->getRepository(Comment::class);
    
        $comment = $commentRepository->find($idComment);
    
        if(!$comment) {
            throw $this->createNotFoundException(
                "Pas de Post trouvé avec l'id ".$idComment
            );
        }
        // On dit au manager que l'on veux supprimer cet objet en base de données
        $entityManager->remove($comment);
        // On met à jour en base de données en supprimant la ligne correspondante (i.e. la requête DELETE)
        $entityManager->flush();
    

        return $this->redirectToRoute('comment.list');
    }
}
