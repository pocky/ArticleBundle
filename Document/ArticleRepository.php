<?php

/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\ArticleBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\DocumentNotFoundException;


/**
 * Class ArticleRepository
 *
 * @package Black\Bundle\ArticleBundle\Document
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ArticleRepository extends DocumentRepository
{
    /**
     * @param $slug
     *
     * @return object
     * @throws \Doctrine\ODM\MongoDB\DocumentNotFoundException
     */
    public function getArticleBySlug($slug)
    {
        $qb = $this->getQueryBuilder()
            ->field('slug')->equals($slug)
            ->getQuery();

        try {
            $article = $qb->getSingleResult();
        } catch (DocumentNotFoundException $e) {
            throw new DocumentNotFoundException(
                sprintf('Unable to find an article object identified by "%s".', $slug)
            );
        }
        return $article;
    }

    /**
     * @param $id
     * @return object
     * @throws \Doctrine\ODM\MongoDB\DocumentNotFoundException
     */
    public function getArticleById($id)
    {
        $qb = $this->getQueryBuilder()
            ->field('id')->equals($id)
            ->getQuery();

        try {
            $article = $qb->getSingleResult();
        } catch (NoResultException $e) {
            throw new DocumentNotFoundException(
                sprintf('Unable to find an article object identified by "%s".', $id)
            );
        }
        return $article;
    }

    /**
     * @param $status
     * @return array|bool|\Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|null
     */
    public function getArticlesByStatus($status)
    {
        $qb = $this->getQueryBuilder()
            ->field('status')->equals($status)
            ->sort('updatedAt', 'desc')
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param $author
     * @param $status
     * @return array|bool|\Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|null
     */
    public function getArticlesByAuthor($author, $status)
    {
        $qb = $this->getQueryBuilder()
            ->field('author')->equals($author)
            ->field('status')->equals($status)
            ->sort('updatedAt', 'desc')
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param $blogCategory
     * @param $status
     * @return array|bool|\Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|null
     */
    public function getArticlesByBlogCategory($blogCategory, $status)
    {
        $qb = $this->getQueryBuilder()
            ->field('blogCategories.name')->equals($blogCategory)
            ->field('status')->equals($status)
            ->sort('updatedAt', 'desc')
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param $keyword
     * @param $status
     * @return array|bool|\Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|null
     */
    public function getArticlesByKeyword($keyword, $status)
    {
        $qb = $this->getQueryBuilder()
            ->field('keywords.name')->equals($keyword)
            ->field('status')->equals($status)
            ->sort('updatedAt', 'desc')
            ->getQuery();

        return $qb->execute();
    }

    /**
     * @param $status
     * @param null $limit
     * @return array|bool|\Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|null
     * @throws \InvalidArgumentException
     */
    public function getArticles($status, $limit = null)
    {
        $qb = $this->getQueryBuilder()
            ->field('status')->equals($status)
            ->sort('updatedAt', 'desc')
        ;

        if ($limit) {
            $qb = $qb->limit($limit);
        }

        $qb = $qb->getQuery();

        return $qb->execute();
    }

    /**
     * @param $status
     * @param $limit
     * @param $articlesPerPage
     * @param $page
     * @return array|bool|\Doctrine\MongoDB\ArrayIterator|\Doctrine\MongoDB\Cursor|\Doctrine\MongoDB\EagerCursor|mixed|null
     * @throws \InvalidArgumentException
     */
    public function getArticlesPaginates($keys, $limit, $articlesPerPage, $page)
    {
        if ($page < 1) {
            throw new \InvalidArgumentException();
        }

        $qb = $this->getQueryBuilder();

        foreach ($keys as $key => $value) {
            $qb = $qb->field($key)->equals($value);
        }

        $qb = $qb
            ->sort('updatedAt', 'desc')
            ->skip($articlesPerPage * ($page - 1))
            ->limit($limit)
        ;

        $qb = $qb->getQuery();

        return $qb->execute();
    }

    /**
     * @param $text
     *
     * @return mixed
     */
    public function searchArticle($text)
    {
        $text = new \MongoRegex('/' . $text . '/\i');

        $qb = $this->getQueryBuilder();
        $qb = $qb
            ->addOr($qb->expr()->field('name')->equals($text))
            ->addOr($qb->expr()->field('articleSection')->equals($text))
            ->addOr($qb->expr()->field('description')->equals($text))
            ->getQuery()
        ;

        return $qb->execute();
    }

    /**
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    protected function getQueryBuilder()
    {
        return $this->createQueryBuilder();
    }
}
