<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ArticleBundle\Document;

use Black\Bundle\CategoryBundle\Model\AbstractCategory;
use Black\Bundle\CategoryBundle\Traits\CategoryDocumentTrait;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Category
 *
 * @ODM\MappedSuperclass()
 * @Gedmo\Tree(type="materializedPath")
 *
 * @package Black\Bundle\CategoryBundle\Document
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class Category extends AbstractCategory
{
    use CategoryDocumentTrait;
}
