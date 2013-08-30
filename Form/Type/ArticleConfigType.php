<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ArticleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ArticleConfigType
 *
 * @package Black\Bundle\ArticleBundle\ControllerForm\Type
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ArticleConfigType extends AbstractType
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param string $class The Person class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('name')
            ->add(
                $builder
                ->create('value', 'form', array(
                        'by_reference'  => false,
                        'label'         => 'admin.adminConfig.article.value.label'
                    )
                )
                ->add('article_protected', 'choice', array(
                        'label'             => 'admin.adminConfig.article.protected.label',
                        'required'          => false,
                        'empty_value'       => 'admin.adminConfig.article.protected.empty',
                        'preferred_choices' => array('false'),
                        'choices'           => array(
                            'true'          => 'admin.adminConfig.article.protected.choices.yes',
                            'false'         => 'admin.adminConfig.article.protected.choices.no'
                        )
                    )
                )
                ->add('article_max', 'text', array(
                        'label'         => 'admin.adminConfig.article.max.label',
                        'required'      => true
                    )
                )
                ->add('article_rss', 'text', array(
                        'label'         => 'admin.adminConfig.article.rss.label',
                        'required'      => true
                    )
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'            => $this->class,
                'intention'             => 'article_config_form',
                'translation_domain'    => 'form'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_article_config';
    }
}
