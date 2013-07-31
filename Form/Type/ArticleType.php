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
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * articleType
 */
class ArticleType extends AbstractType
{
    protected $class;
    protected $enabled;
    protected $status;

    /**
     * @param                     $class
     * @param ChoiceListInterface $enabled
     * @param ChoiceListInterface $status
     */
    public function __construct($class, ChoiceListInterface $enabled, ChoiceListInterface $status)
    {
        $this->class    = $class;
        $this->enabled  = $enabled;
        $this->status   = $status;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                array(
                    'label'         => 'article.admin.article.name.text'
                )
            )
            ->add(
                'alternativeHeadline',
                'text',
                array(
                    'label'         => 'article.admin.article.alternativeHeadline.text'
                )
            )
            ->add(
                'slug',
                'text',
                array(
                    'label'         => 'article.admin.article.slug.text',
                    'required'      => false
                )
            )
            ->add(
                'description',
                'textarea',
                array(
                    'label'         => 'article.admin.article.description.text',
                    'required'      => false
                )
            )
            ->add(
                'articleBody',
                'ckeditor',
                array(
                    'label'         => 'article.admin.article.articleBody.text',
                    'filebrowser_image_browse_url' => array(
                        'route'            => 'elfinder',
                        'route_parameters' => array(),
                    ),
                )
            )
            ->add(
                'articleSection',
                'text',
                array(
                    'label'         => 'article.admin.article.articleSection.text'
                )
            )

            ->add(
                'contentLocation',
                'text',
                array(
                    'label'         => 'article.admin.article.contentLocation.text'
                )
            )

            ->add(
                'contentRating',
                'text',
                array(
                    'label'         => 'article.admin.article.contentRating.text'
                )
            )
            ->add(
                'isFamilyFriendly',
                'text',
                array(
                    'label'         => 'article.admin.article.genre.text'
                )
            )

            ->add(
                'genre',
                'text',
                array(
                    'label'         => 'article.admin.article.genre.text'
                )
            )
            ->add(
                'inLanguage',
                'text',
                array(
                    'label'         => 'article.admin.article.inLanguage.text'
                )
            )
            ->add(
                'inBasedOnUrls',
                'text',
                array(
                    'label'         => 'article.admin.article.isBasedOnUrls.text'
                )
            )

            ->add(
                'discussionUrl',
                'text',
                array(
                    'label'         => 'article.admin.article.discussionUrl.text',
                    'required'      => false
                )
            )

            ->add(
                'author',
                'text',
                array(
                    'label'         => 'article.admin.article.author.text',
                    'required'      => false
                )
            )
            ->add(
                'contributors',
                'text',
                array(
                    'label'         => 'article.admin.article.contributors.text',
                    'required'      => false
                )
            )
            ->add(
                'copyrightHolder',
                'text',
                array(
                    'label'         => 'article.admin.article.copyrightHolder.text',
                    'required'      => false
                )
            )
            ->add(
                'copyrightYear',
                'date',
                array(
                    'label'         => 'article.admin.article.copyrightYear.text',
                    'years'         => array_reverse(
                        range(2000, date('Y', strtotime('now')))
                    ),
                    'required'      => false,
                    'empty_value'   => array(
                        'year' => 'article.admin.article.copyrightYear.choice.year.text'
                    )
                )
            )
            ->add(
                'keywords',
                'text',
                array(
                    'label'         => 'article.admin.article.copyrightHolder.text',
                    'required'      => false
                )
            )
            ->add(
                'mentions',
                'text',
                array(
                    'label'         => 'article.admin.article.mentions.text',
                    'required'      => false
                )
            )
            ->add(
                'provider',
                'text',
                array(
                    'label'         => 'article.admin.article.provider.text',
                    'required'      => false
                )
            )
            ->add(
                'publisher',
                'text',
                array(
                    'label'         => 'article.admin.article.publisher.text',
                    'required'      => false
                )
            )
            ->add(
                'version',
                'text',
                array(
                    'label'         => 'article.admin.article.version.text',
                    'required'      => false
                )
            )
            ->add(
                'status',
                'choice',
                array(
                    'label'         => 'article.admin.article.status.text',
                    'empty_value'   => 'article.admin.article.status.empty',
                    'choice_list'   => $this->status
                )
            )
            ->add(
                'enabled',
                'choice',
                array(
                    'label'         => 'article.admin.article.enabled.text',
                    'empty_value'   => 'article.admin.article.enabled.empty',
                    'choice_list'   => $this->enabled
                )
            )
            ->add(
                'datePublished',
                'date',
                array(
                    'label'         => 'article.admin.article.datePublished.text',
                    'years'         => array_reverse(
                        range(2000, date('Y', strtotime('now')))
                    ),
                    'required'      => false,
                    'empty_value'   => array(
                        'year' => 'article.admin.article.datePublished.choice.year.text',
                        'month' => 'article.admin.article.datePublished.choice.month.text',
                        'day' => 'article.admin.article.datePublished.choice.day.text')
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
