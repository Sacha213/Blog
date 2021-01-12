<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PostController extends AbstractController
{
    /**
     * @Route("/post/{namePost}") 
     */

    public function show($namePost)
    {
        return $this->render('post/show.html.twig', [
            'namePost' => $namePost
        ]);
    }

    public function list($namePost)
    {
        return $this->render('post/list.html.twig', [
            'namePost' => $namePost
        ]);
    }

    public function create($namePost)
    {
        return $this->render('post/create.html.twig', [
            'namePost' => $namePost
        ]);
    }

    public function edit($namePost)
    {
        return $this->render('post/edit.html.twig', [
            'namePost' => $namePost
        ]);
    }

    public function remove($namePost)
    {
        return $this->render('post/remove.html.twig', [
            'namePost' => $namePost
        ]);
    }
}
