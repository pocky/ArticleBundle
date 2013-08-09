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

use Black\Bundle\ArticleBundle\Model\Article as AbstractArticle;
use Black\Bundle\CommonBundle\Traits\ThingEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Article
 *
 * @package Black\Bundle\ArticleBundle\Entity
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class Article extends AbstractArticle
{
    use ThingEntityTrait;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="alternativeHeadline", type="string", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $alternativeHeadline;

    /**
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    protected $author;

    /**
     * @ORM\Column(name="articleSection", type="string", nullable=true)
     * @Assert\Type(type="string")
     */
    protected $articleSection;

    /**
     * @ORM\Column(name="date_published", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    protected $datePublished;

    /**
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    protected $status;

    /**
     * @ORM\Column(name="enabled", type="string", length=255, nullable=true)
     */
    protected $enabled;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }
}
