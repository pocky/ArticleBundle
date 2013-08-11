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
     * @Route("/all.html", name="articles")
     * @Template()
     * 
     * @return array
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function indexAction()
    {
        $documentManager    = $this->getManager();
        $documents          = $documentManager->findPublishedArticles();

        if (!$documents) {
            throw $this->createNotFoundException('article.not.found');
        }

        return array(
            'documents' => $documents,
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
     * @Route("/recent/{max}", name="_articles_recent")
     * @Template()
     * 
     * @return Template
     */
    public function recentArticlesAction($max = 3)
    {
        $documentManager    = $this->getManager();
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
    protected function getManager()
    {
        return $this->get('black_article.manager.article');
    }

    protected function getProxy()
    {
        return $this->get('black_article.proxy');
    }
}
