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

use Black\Bundle\ArticleBundle\Model\Article as AbstractArticle;
use Black\Bundle\CommonBundle\Traits\ThingDocumentTrait;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Article
 *
 * @ODM\MappedSuperclass()
 *
 * @package Black\Bundle\ArticleBundle\Document
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class Article extends AbstractArticle
{
    use ThingDocumentTrait;

    /**
     * @ODM\Id
     */
    protected $id;

    /**
     * @ODM\String
     */
    protected $alternativeHeadline;

    /**
     * @ODM\String
     */
    protected $author;

    /**
     * @ODM\String
     */
    protected $articleSection;

    /**
     * @ODM\Collection
     */
    protected $blogCategories;

    /**
     * @ODM\Date
     * @Gedmo\Timestampable(on="create")
     */
    protected $datePublished;

    /**
     * @ODM\Collection
     */
    protected $keywords;

    /**
     * @ODM\String
     */
    protected $status;

    /**
     * @ODM\String
     */
    protected $enabled;
}
