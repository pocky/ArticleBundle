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

use Black\Bundle\ArticleBundle\Model\Item as AbstractItem;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Item Document
 *
 * @ODM\EmbeddedDocument()
 */
class Item extends AbstractItem
{
    /**
     * @ODM\String
     * @Assert\Length(max="255")
     * @Assert\Type(type="string")
     */
    protected $name;
}
