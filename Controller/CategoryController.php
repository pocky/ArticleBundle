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

use Psr\Log\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class CategoryController
 *
 * @Route("/category")
 *
 * @package Black\Bundle\ArticleBundle\Controller
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CategoryController extends Controller
{
    /**
     * Get a category (embed action)
     * 
     * @Method("GET")
     * @Route("/", name="_find_category")
     * @Template()
     * 
     * @return Template
     */
    public function categoryAction()
    {
        $documentManager    = $this->getManager();
        $documentRepository = $documentManager->getRepository();

        $tree = array();

        $tree = $documentRepository->childrenHierarchy(null, false, array(
                'decorate'  => true,
                'representationField' => 'slug',
                'html'  => true,
                'rootOpen' => function($tree) {
                    if (count($tree) && ($tree[0]['level'] == 1)) {
                        return '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';
                    }
                },
                'rootClose' => function($child) {
                    if (count($child) && ($child[0]['level'] == 1)) {
                        return '</ul>';
                    }
                },
                'nodeDecorator' => function($node) use (&$controller) {
                    return '<a href="/articles/category/'.$node['name'].'.html">'.$node['name'].'</a>';
                }
            ));

        return array(
            'document' => $tree,
        );
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    protected function getManager()
    {
        return $this->get('black_article.manager.category');
    }
}
