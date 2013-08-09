<?php

/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\ArticleBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NoResultException;

/**
 * Class ArticleRepository
 *
 * @package Black\Bundle\ArticleBundle\Entity
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ArticleRepository extends EntityRepository
{
    /**
     * @param $slug
     *
     * @return mixed
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getArticleBySlug($slug)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.slug LIKE :slug')
                ->setParameter('slug', $slug)
                ->getQuery();

        try {
            $article = $qb->getSingleResult();
        } catch (NoResultException $e) {
            throw new EntityNotFoundException(
                sprintf('Unable to find an article object identified by "%s".', $slug)
            );
        }
        return $article;
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getArticleById($id)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery();

        try {
            $article = $qb->getSingleResult();
        } catch (EntityNotFoundException $e) {
            throw new EntityNotFoundException(
                sprintf('Unable to find an article object identified by "%s".', $id)
            );
        }
        return $article;
    }

    /**
     * @param string $status
     * 
     * @return array
     */
    public function getArticlesByStatus($status)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.status LIKE :status')
                ->orderBy('p.updatedAt', 'desc')
                ->setParameter('status', $status)
                ->getQuery();

        return $qb->execute();
    }

    /**
     * @param string  $status
     * @param integer $limit
     * 
     * @return array
     */
    public function getArticles($status, $limit = null)
    {
        $qb = $this->getQueryBuilder()
                ->where('p.status LIKE :status')
                ->orderBy('p.updatedAt', 'desc')
                ->setParameter('status', $status);

        if ($limit) {
            $qb = $qb->limit($limit);
        }

        $qb = $this->getQuery();

        return $qb->execute();
    }

    /**
     * @param $text
     *
     * @return mixed
     */
    public function searchArticle($text)
    {
        $qb = $this->getQueryBuilder();

        $qb = $qb
            ->where($qb->expr()->orX(
                    $qb->expr()->like('name', 'text'),
                    $qb->expr()->like('articleSection', 'text'),
                    $qb->expr()->like('description', 'text')
                ))
            ->setParameter('text', '%' . $text . '%')
            ->getQuery()
        ;

        return $qb->execute();
    }

    /**
     * @param string $alias
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function getQueryBuilder($alias = 'p')
    {
        return $this->createQueryBuilder($alias);
    }
}
