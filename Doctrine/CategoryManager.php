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

use Black\Bundle\CategoryBundle\Model\CategoryManagerInterface;
use Black\Bundle\CategoryBundle\Traits\CategoryManagerTrait;

/**
 * Class PageManager
 *
 * @package Black\Bundle\CategoryBundle\Doctrine
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class CategoryManager implements CategoryManagerInterface
{
    use CategoryManagerTrait;
}
