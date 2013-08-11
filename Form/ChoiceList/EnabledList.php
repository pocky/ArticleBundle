<?php
/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ArticleBundle\Form\ChoiceList;

use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * EnabledList
 */
class EnabledList extends LazyChoiceList
{
    /**
     * @return SimpleChoiceList
     */
    protected function loadChoiceList()
    {
        $array = array(
            'public'    => 'article.admin.article.enabled.choice.public',
            'private'   => 'article.admin.article.enabled.choice.private'
        );

        $choices = new SimpleChoiceList($array);

        return $choices;
    }
}
