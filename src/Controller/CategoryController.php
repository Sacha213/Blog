<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{nameCategory}") 
     */

    public function show($nameCategory)
    {
        return $this->render('category/show.html.twig', [
            'nameCategory' => $nameCategory
        ]);
    }

    public function list($nameCategory)
    {
        return $this->render('category/list.html.twig', [
            'nameCategory' => $nameCategory
        ]);
    }

    public function create($nameCategory)
    {
        return $this->render('category/create.html.twig', [
            'nameCategory' => $nameCategory
        ]);
    }

    public function edit($nameCategory)
    {
        return $this->render('category/edit.html.twig', [
            'nameCategory' => $nameCategory
        ]);
    }

    public function remove($nameCategory)
    {
        return $this->render('category/remove.html.twig', [
            'nameCategory' => $nameCategory
        ]);
    }
}
