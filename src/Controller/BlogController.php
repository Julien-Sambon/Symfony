<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Article;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function list(CategoryRepository $CategoryRepository)
    {
        $category = $CategoryRepository->findAll();

        return $this->render('blog/index.html.twig', [
            'categories' => $category
        ]);
    }

    /**
     * @Route("/blog/show/{id}", name="blog_article")
     */
    public function show(ArticleRepository $articleRepository, $id)
    {
        if(empty($id))
            $article = null;
        elseif(!empty($id)) {
            $article = $articleRepository->find($id);
        }
        return $this->render('blog/show.html.twig', [
            'article' => $article

        ]);
    }
}
