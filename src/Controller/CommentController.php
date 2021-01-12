<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CommentController extends AbstractController
{
    /**
     * @Route("/comment/{nameComment}") 
     */

    public function show($nameComment)
    {
        return $this->render('comment/show.html.twig', [
            'nameComment' => $nameComment
        ]);
    }

    public function list($nameComment)
    {
        return $this->render('comment/list.html.twig', [
            'nameComment' => $nameComment
        ]);
    }

    public function create($nameComment)
    {
        return $this->render('comment/create.html.twig', [
            'nameComment' => $nameComment
        ]);
    }

    public function edit($nameComment)
    {
        return $this->render('comment/edit.html.twig', [
            'nameComment' => $nameComment
        ]);
    }

    public function remove($nameComment)
    {
        return $this->render('comment/remove.html.twig', [
            'nameComment' => $nameComment
        ]);
    }

}
