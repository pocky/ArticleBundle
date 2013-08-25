<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Controller managing the Articles`
 *
 * @Route("/article")
 *
 * @package Black\Bundle\ArticleBundle\Controller
 */
class ArticleController extends Controller
{
    /**
     * index of Articles
     *
     * @Method("GET")
     * @Route("s.html", name="articles")
     * @Route("s/{page}.html", name="articles_paginate", requirements={"page" = "\d+"})
     * @Template()
     * 
     * @param int $limit
     * @param int $articlesPerPage
     * @param int $page
     *
     * @return array
     */
    public function indexAction($limit = 1, $articlesPerPage = 1, $page = 1)
    {
        $articleManager = $this->getArticleManager();

        $countArticles  = $articleManager->getRepository()->findAll()->count();
        $maxPage        = ceil($countArticles / $articlesPerPage);
        $nextPage       = $maxPage > $page ? ($page + 1) : false;
        $documents      = $articleManager->findPublishedAndPaginateArticles($limit, $articlesPerPage, $page);

        return array(
            'documents' => $documents,
            'page'      => $page,
            'nextPage'  => $nextPage
        );
    }

    /**
     * Articles for Author
     *
     * @Method("GET")
     * @Route("s/author/{author}.html", name="article_author")
     * @Route("s/author/{author}/{page}.html", name="article_author_paginate", requirements={"page" = "\d+"})
     * @Template()
     *
     * @param $author
     * @param int $limit
     * @param int $articlesPerPage
     * @param int $page
     *
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function authorAction($author, $limit = 1, $articlesPerPage = 1, $page = 1)
    {
        $articleManager = $this->getArticleManager();

        $documents      = $articleManager->findPublishedAndPaginateArticlesByAuthor($author, $limit, $articlesPerPage, $page);
        $countArticles  = $documents->count();
        $maxPage        = ceil($countArticles / $articlesPerPage);
        $nextPage       = $maxPage > $page ? ($page + 1) : false;

        return array(
            'documents' => $documents,
            'page'      => $page,
            'nextPage'  => $nextPage,
            'author'    => $author
        );
    }

    /**
     * Articles for Category
     *
     * @Method("GET")
     * @Route("s/category/{blogCategory}.html", name="article_category")
     * @Route("s/category/{blogCategory}/{page}.html", name="article_category_paginate", requirements={"page" = "\d+"})
     * @Template()
     *
     * @param $blogCategory
     * @param int $limit
     * @param int $articlesPerPage
     * @param int $page
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function categoryAction($blogCategory, $limit = 1, $articlesPerPage = 1, $page = 1)
    {
        $categoryManager      = $this->getCategoryManager();

        if (!$blogCategory = $categoryManager->getRepository()->findOneBySlug($blogCategory)) {
            $this->createNotFoundException();
        }

        $documentManager    = $this->getArticleManager();
        $documents          = $documentManager->findPublishedAndPaginateArticlesByBlogCategory($blogCategory, $limit, $articlesPerPage, $page);
        $countArticles      = $documents->count();
        $maxPage            = ceil($countArticles / $articlesPerPage);
        $nextPage           = $maxPage > $page ? ($page + 1) : false;

        return array(
            'documents'     => $documents,
            'page'          => $page,
            'nextPage'      => $nextPage,
            'blogCategory'  => $blogCategory
        );
    }

    /**
     * Articles for keyword
     *
     * @Method("GET")
     * @Route("s/keyword/{keyword}.html", name="article_keyword")
     * @Route("s/keyword/{keyword}/{page}.html", name="article_keyword_paginate", requirements={"page" = "\d+"})
     * @Template()
     *
     * @param $keyword
     * @param int $limit
     * @param int $articlesPerPage
     * @param int $page
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function keywordAction($keyword, $limit = 1, $articlesPerPage = 1, $page = 1)
    {
        $documentManager    = $this->getArticleManager();
        $documents          = $documentManager->findPublishedAndPaginateArticlesByKeyword($keyword, $limit, $articlesPerPage, $page);
        $countArticles      = $documents->count();
        $maxPage            = ceil($countArticles / $articlesPerPage);
        $nextPage           = $maxPage > $page ? ($page + 1) : false;

        return array(
            'documents'     => $documents,
            'page'          => $page,
            'nextPage'      => $nextPage,
            'keyword'       => $keyword
        );
    }

    /**
     * Show article by slug
     *
     * @param string $slug
     * 
     * @Method("GET")
     * @Route("/{slug}.html", name="article_show")
     * @Template()
     * 
     * @return Template
     */
    public function showAction($slug)
    {
        $proxy      = $this->getProxy();
        $response   = $proxy->createResponse($slug);

        return $this->render(
            'BlackArticleBundle:Article:show.html.twig',
            array('document' => $response['object']),
            $response['response']
        );
    }

    /**
     * Recent articles (embed action)
     * 
     * @param integer $max
     * 
     * @Method("GET")
     * @Route("s/recent/{max}", name="_articles_recent")
     * @Template()
     * 
     * @return Template
     */
    public function recentArticlesAction($max = 3)
    {
        $documentManager    = $this->getArticleManager();
        $documents = $documentManager->findLastPublishedArticles($max);

        return array(
            'documents' => $documents,
        );
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    protected function getArticleManager()
    {
        return $this->get('black_article.manager.article');
    }

    /**
     * @return object
     */
    protected function getProxy()
    {
        return $this->get('black_article.proxy');
    }
}
