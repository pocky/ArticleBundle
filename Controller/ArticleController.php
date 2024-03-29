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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class ArticleController
 *
 * @Route("/article")
 *
 * @package Black\Bundle\ArticleBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ArticleController extends Controller
{
    /**
     * index of Articles
     *
     * @Method("GET")
     * @Route("s.{_format}", name="articles", requirements={"_format" = "html|xml"})
     * @Route("s/{page}.html", name="articles_paginate", requirements={"page" = "\d+"})
     * @Template()
     *
     * @param int $page
     *
     * @return array
     */
    public function indexAction($page = 1)
    {
        $articleManager     = $this->getArticleManager();
        $configManager      = $this->getConfigManger();
        $property           = $configManager->findPropertyByName('Article');
        $format             = $this->get('request')->get('_format');

        if ('xml' == $format) {

            $data = $articleManager->findLastPublishedArticles($property->getValue()['article_rss']);

            foreach ($data as $document) {
                $documents[] = $document;
            }

            return array(
                'channel'       => $configManager->findPropertyByName('General'),
                'lastBuildDate' => $documents[0]->getDatePublished(),
                'documents'     => $documents
            );
        }

        $articlesPerPage    = $property->getValue()['article_max'];
        $countArticles  = $articleManager->getRepository()->findAll()->count();
        $maxPage        = ceil($countArticles / $articlesPerPage);
        $nextPage       = $maxPage > $page ? ($page + 1) : false;
        $documents      = $articleManager->findPublishedAndPaginateArticles($articlesPerPage, $page);

        return array(
            'count'     => $countArticles,
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
     * @param int $page
     *
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function authorAction($author, $page = 1)
    {
        $articleManager     = $this->getArticleManager();
        $configManager      = $this->getConfigManger();
        $property           = $configManager->findPropertyByName('Article');
        $articlesPerPage    = $property->getValue()['article_max'];

        $documents      = $articleManager->findPublishedAndPaginateArticlesByAuthor($author, $articlesPerPage, $page);
        $countArticles  = $documents->count();
        $maxPage        = ceil($countArticles / $articlesPerPage);
        $nextPage       = $maxPage > $page ? ($page + 1) : false;

        return array(
            'count'     => $countArticles,
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
     * @param int $page
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function categoryAction($blogCategory, $page = 1)
    {
        $categoryManager        = $this->getCategoryManager();
        $configManager          = $this->getConfigManger();
        $property               = $configManager->findPropertyByName('Article');
        $articlesPerPage        = $property->getValue()['article_max'];

        if (!$blogCategory = $categoryManager->getRepository()->findOneBySlug($blogCategory)) {
            $this->createNotFoundException();
        }

        $documentManager    = $this->getArticleManager();
        $documents          = $documentManager->findPublishedAndPaginateArticlesByBlogCategory($blogCategory, $articlesPerPage, $page);
        $countArticles      = $documents->count();
        $maxPage            = ceil($countArticles / $articlesPerPage);
        $nextPage           = $maxPage > $page ? ($page + 1) : false;

        return array(
            'count'         => $countArticles,
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
     * @param int $page
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function keywordAction($keyword, $page = 1)
    {
        $documentManager    = $this->getArticleManager();
        $configManager      = $this->getConfigManger();
        $property           = $configManager->findPropertyByName('Article');
        $articlesPerPage    = $property->getValue()['article_max'];

        $documents          = $documentManager->findPublishedAndPaginateArticlesByKeyword($keyword, $articlesPerPage, $page);
        $countArticles      = $documents->count();
        $maxPage            = ceil($countArticles / $articlesPerPage);
        $nextPage           = $maxPage > $page ? ($page + 1) : false;

        return array(
            'documents'     => $documents,
            'page'          => $page,
            'nextPage'      => $nextPage,
            'keyword'       => $keyword,
            'count'         => $countArticles
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
        $documents          = $documentManager->findLastPublishedArticles($max);

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
    protected function getConfigManger()
    {
        return $this->get('black_config.manager.config');
    }

    /**
     * @return object
     */
    protected function getProxy()
    {
        return $this->get('black_article.proxy');
    }
}
