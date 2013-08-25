<?php

/*
 * This file is part of the Blackengine package.
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
 * Class ArticleType
 *
 * @package Black\Bundle\ArticleBundle\Form\Type
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ArticleType extends AbstractType
{
    /**
     * @var
     */
    protected $class;

    /**
     * @param $class
     */
    public function __construct($class)
    {
        $this->class    = $class;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                    'label'         => 'article.admin.article.name.text'
                )
            )
            ->add('alternativeHeadline', 'text', array(
                    'label'         => 'article.admin.article.alternativeHeadline.text',
                    'required'      => false
                )
            )
            ->add('slug', 'text', array(
                    'label'         => 'article.admin.article.slug.text',
                    'required'      => false
                )
            )
            ->add('description', 'textarea', array(
                    'label'         => 'article.admin.article.description.text',
                    'required'      => false,
                    'attr'          => array(
                        'class'         => 'tinymce',
                        'data-theme'    => 'advanced'
                    )
                )
            )
            ->add('articleSection', 'textarea', array(
<<<<<<< HEAD
                    'label'         => 'article.admin.article.articleSection.text',
=======
                    'label'                         => 'article.admin.article.articleSection.text',
>>>>>>> release/0.0.3
                    'attr'          => array(
                        'class'         => 'tinymce',
                        'data-theme'    => 'advanced'
                    )
                )
            )

            ->add('blogCategories', 'collection', array(
                    'type'          => 'black_article_category',
                    'label'         => 'article.admin.article.blogCategories.text',
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'required'      => false,
                    'attr'          => array(
                        'class' => 'blogCategories-collection',
                        'add'   => 'add-another-category'
                    ),
                )
            )

            ->add('keywords', 'collection', array(
                    'type'          => 'black_article_item',
                    'label'         => 'article.admin.article.keywords.text',
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'required'      => false,
                    'attr'          => array(
                        'class' => 'keywords-collection',
                        'add'   => 'add-another-keyword'
                    ),
                )
            )

            ->add('author', 'text', array(
                    'label'         => 'article.admin.article.author.text',
                    'required'      => false
                )
            )
            ->add('status', 'black_article_choice_list_status', array(
                    'label'         => 'article.admin.article.status.text',
                    'empty_value'   => 'article.admin.article.status.empty',
                    'required'      => true
                )
            )
            ->add('enabled', 'black_article_choice_list_enabled', array(
                    'label'         => 'article.admin.article.enabled.text',
                    'empty_value'   => 'article.admin.article.enabled.empty',
                    'required'      => true
                )
            )
            ->add('datePublished', 'date', array(
                    'label'         => 'article.admin.article.datePublished.text',
                    'years'         => array_reverse(
                        range(2000, date('Y', strtotime('now')))
                    ),
                    'required'      => false,
                    'empty_value'   => array(
                        'year' => 'article.admin.article.datePublished.choice.year.text',
                        'month' => 'article.admin.article.datePublished.choice.month.text',
                        'day' => 'article.admin.article.datePublished.choice.day.text'
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
                'data_class'    => $this->class,
                'intention'     => 'article_form'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_article_article';
    }
}
