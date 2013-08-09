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

use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\LazyChoiceList;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

/**
 * EnabledList
 */
class EnabledList extends LazyChoiceList
{
    /**
     * @var \Black\Bundle\ConfigBundle\Model\ConfigManagerInterface
     */
    private $manager;

    /**
     * @param \Black\Bundle\ConfigBundle\Model\ConfigManagerInterface $manager
     */
    public function __construct(ConfigManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return SimpleChoiceList
     */
    protected function loadChoiceList()
    {
        $property   = $this->getPageProperty();

        $array = array(
            'public'    => 'article.admin.article.enabled.choice.public',
            'private'   => 'article.admin.article.enabled.choice.private'
        );

        if ('true' === $property['page_protected']) {
            $array += array(
                'protected' => 'article.admin.article.enabled.choice.protected'
            );
        }

        $choices = new SimpleChoiceList($array);

        return $choices;
    }

    /**
     * @return mixed
     */
    protected function getPageProperty()
    {
        $property = $this->manager->findPropertyByName('Page');

        return $property->getValue();
    }
}
