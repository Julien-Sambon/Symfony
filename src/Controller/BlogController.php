<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Article;
use DateTime;
use DateInterval;
use DatePeriod;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(CategoryRepository $CategoryRepository)
    {
        $category = $CategoryRepository->findAll();

        return $this->render('blog/index.html.twig', [
            'categories' => $category,
        ]);
    }

    /**
     * @Route("/blog/article/{articleTitle}", name="blog_article")
     */
    public function show(ArticleRepository $articleRepository, $articleTitle)
    {
        $articleTitle = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($articleTitle)), "-")
        );

        if(empty($articleTitle))
            $article = null;
        elseif(!empty($articleTitle)) {
            $article = $articleRepository->findOneByTitle($articleTitle);
        }
        return $this->render('blog/show.html.twig', [
            'article' => $article

        ]);
    }

    /**
     * @Route("/blog/category/{category}", name="blog_show_category")
     */
    public function showByCategory(CategoryRepository $categoryRepository, ArticleRepository $articleRepository, string $category)
    {
        $category = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($category)), "-")
        );

        $categoryFind = $categoryRepository->findOneByName($category);
        if ($categoryFind) {
            $articleFind = $articleRepository->findBy(
                ["category" => $categoryFind->getId()],
                ["id" => 'DESC'],
                3);
        }
        else
            $articleFind = null;

        return $this->render('blog/category.html.twig', [
            'articles' => $articleFind,
            'category' => $categoryFind
        ]);
    }
}
