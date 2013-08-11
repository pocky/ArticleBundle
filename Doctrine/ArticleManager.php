<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ArticleBundle\Doctrine;

use Black\Bundle\ArticleBundle\Model\ArticleManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;


/**
 * Class ArticleManager
 *
 * @package Black\Bundle\ArticleBundle\Doctrine
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ArticleManager implements ArticleManagerInterface
{
    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor
     *
     * @param ObjectManager $dm
     * @param string        $class
     */
    public function __construct(ObjectManager $dm, $class)
    {
        $this->manager     = $dm;
        $this->repository  = $dm->getRepository($class);

        $metadata          = $dm->getClassMetadata($class);
        $this->class       = $metadata->name;
    }

    /**
     * @return ObjectManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param object $model
     *
     * @throws \InvalidArgumentException
     */
    public function persist($model)
    {
        if (!$model instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($model));
        }

        $this->getManager()->persist($model);
    }

    /**
     * Flush
     */
    public function flush()
    {
        $this->getManager()->flush();
    }

    /**
     * Remove the model
     * 
     * @param object $model
     *
     * @throws \InvalidArgumentException
     */
    public function remove($model)
    {
        if (!$model instanceof $this->class) {
            throw new \InvalidArgumentException(gettype($model));
        }
        $this->getManager()->remove($model);
    }

    /**
     * Save and Flush a new model
     *
     * @param mixed $model
     */
    public function persistAndFlush($model)
    {
        $this->persist($model);
        $this->flush();
    }

    /**
     * Remove and flush
     * 
     * @param mixed $model
     */
    public function removeAndFlush($model)
    {
        $this->getManager()->remove($model);
        $this->getManager()->flush();
    }

    /**
     * Create a new model
     *
     * @return $config object
     */
    public function createInstance()
    {
        $class  = $this->getClass();
        $model = new $class;

        return $model;
    }

    /**
     * @return string
     */
    protected function getClass()
    {
        return $this->class;
    }

    /**
     * @param $text
     *
     * @return mixed
     */
    public function findArticle($text)
    {
        return $this->getRepository()->searchArticle($text);
    }

    /**
     * @param string $slug
     * 
     * @return mixed
     */
    public function findArticleBySlug($slug)
    {
        return $this->getRepository()->getArticleBySlug($slug);
    }

    /**
     * @param integer $id
     * 
     * @return mixed
     */
    public function findArticleById($id)
    {
        return $this->getRepository()->getArticleByid($id);
    }

    /**
     * @return array
     */
    public function findDraftArticles()
    {
        return $this->getRepository()->getArticlesByStatus('draft');
    }

    /**
     * @return array
     */
    public function findPublishedArticles()
    {
        return $this->getRepository()->getArticlesByStatus('publish');
    }

    /**
     * @param integer $limit
     * 
     * @return array
     */
    public function findLastPublishedArticles($limit = 3)
    {
        return $this->getRepository()->getArticles('publish', $limit);
    }

    /**
     * @param integer $limit
     * 
     * @return array
     */
    public function findLastDraftArticles($limit = 3)
    {
        return $this->getRepository()->getArticles('draft', $limit);
    }

    /**
     * @param $author
     * @param string $status
     *
     * @return mixed
     */
    public function findArticlesByAuthor($author, $status = 'publish')
    {
        return $this->getRepository()->getArticlesByAuthor($author, $status);
    }

    /**
     * @param $blogCategory
     * @param string $status
     *
     * @return mixed
     */
    public function findArticlesByBlogCategory($blogCategory, $status = 'publish')
    {
        return $this->getRepository()->getArticlesByBlogCategory($blogCategory, $status);
    }

    /**
     * @param $keyword
     * @param string $status
     *
     * @return mixed
     */
    public function findArticlesByKeyword($keyword, $status = 'publish')
    {
        return $this->getRepository()->getArticlesByKeyword($keyword, $status);
    }
}
