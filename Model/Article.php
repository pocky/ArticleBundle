<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ArticleBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Article
 *
 * @package Black\Bundle\ArticleBundle\Model
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
abstract class Article implements ArticleInterface
{
    /**
     * @var
     */
    protected $alternativeHeadline;

    /**
     * @var
     */
    protected $author;

    /**
     * @var
     */
    protected $blogCategories;

    /**
     * @var
     */
    protected $comments;

    /**
     * @var
     */
    protected $contentLocation;

    /**
     * @var
     */
    protected $contentRating;

    /**
     * @var
     */
    protected $contributors;

    /**
     * @var
     */
    protected $copyrightHolder;

    /**
     * @var
     */
    protected $copyrightYear;

    /**
     * @var
     */
    protected $datePublished;

    /**
     * @var
     */
    protected $discussionUrl;

    /**
     * @var
     */
    protected $enabled;

    /**
     * @var
     */
    protected $genre;

    /**
     * @var
     */
    protected $inLanguage;

    /**
     * @var
     */
    protected $isBasedOnUrls;

    /**
     * @var
     */
    protected $isFamilyFriendly;

    /**
     * @var
     */
    protected $keywords;

    /**
     * @var
     */
    protected $mentions;

    /**
     * @var
     */
    protected $provider;

    /**
     * @var
     */
    protected $publisher;

    /**
     * @var
     */
    protected $status;

    /**
     * @var
     */
    protected $version;

    /**
     * @var
     */
    protected $articleBody;

    /**
     * @var
     */
    protected $articleSection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->blogCategories   = new ArrayCollection();
        $this->keywords         = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $alternativeHeadline
     *
     * @return $this
     */
    public function setAlternativeHeadline($alternativeHeadline)
    {
        $this->alternativeHeadline = $alternativeHeadline;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlternativeHeadline()
    {
        return $this->alternativeHeadline;
    }

    /**
     * @param $author
     *
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param ArrayCollection $blogCategories
     * @return $this
     */
    public function setBlogCategories(ArrayCollection $blogCategories)
    {
        foreach ($blogCategories as $blogCategory) {
            $this->setBlogCategory($blogCategory);
        }

        return $this;
    }

    /**
     * @param $blogCategory
     * @return $this
     */
    public function setBlogCategory($blogCategory)
    {
        $this->addBlogCategory($blogCategory);

        return $this;
    }

    /**
     * @param $blogCategory
     * @return $this
     */
    public function addBlogCategory($blogCategory)
    {
        if (!$this->blogCategories->contains($blogCategory)) {
            $this->blogCategories->add($blogCategory);
        }

        return $this;
    }

    /**
     * @param $blogCategory
     * @return $this
     */
    public function removeBlogCategory($blogCategory)
    {
        if ($this->blogCategories->contains($blogCategory)) {
            $this->blogCategories->removeElement($blogCategory);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBlogCategories()
    {
        return $this->blogCategories;
    }

    /**
     * @param ArrayCollection $comments
     *
     * @return $this
     */
    public function setComments(ArrayCollection $comments)
    {
        foreach ($comments as $comment) {
            $this->setComment($comment);
        }

        return $this;
    }

    /**
     * @param $comment
     */
    public function setComment($comment)
    {
        $this->addComment($comment);
    }

    /**
     * @param $comment
     */
    public function addComment($comment)
    {
        $this->comments->add($comment);
    }

    /**
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param $contentLocation
     *
     * @return $this
     */
    public function setContentLocation($contentLocation)
    {
        $this->contentLocation = $contentLocation;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentLocation()
    {
        return $this->contentLocation;
    }

    /**
     * @param $contentRating
     *
     * @return $this
     */
    public function setContentRating($contentRating)
    {
        $this->contentRating = $contentRating;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentRating()
    {
        return $this->contentRating;
    }

    /**
     * @param ArrayCollection $contributors
     *
     * @return $this
     */
    public function setContributors(ArrayCollection $contributors)
    {
        foreach ($contributors as $contributor) {
            $this->setContributor($contributor);
        }

        return $this;
    }

    /**
     * @param $contributor
     */
    public function setContributor($contributor)
    {
        $this->addContributor($contributor);
    }

    /**
     * @param $contributor
     */
    public function addContributor($contributor)
    {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors->add($contributor);
        }
    }

    /**
     * @param $contributor
     */
    public function removeContributor($contributor)
    {
        if ($this->contributors->contains($contributor)) {
            $this->contributors->removeElement($contributor);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getContributors()
    {
        return $this->contributors;
    }

    /**
     * @param $copyrightHolder
     *
     * @return $this
     */
    public function setCopyrightHolder($copyrightHolder)
    {
        $this->copyrightHolder = $copyrightHolder;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCopyrightHolder()
    {
        return $this->copyrightHolder;
    }

    /**
     * @param $copyrightYear
     *
     * @return $this
     */
    public function setCopyrightYear($copyrightYear)
    {
        $this->copyrightYear = $copyrightYear;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCopyrightYear()
    {
        return $this->copyrightYear;
    }

    /**
     * @param $datePublished
     *
     * @return $this
     */
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * @param $discussionUrl
     *
     * @return $this
     */
    public function setDiscussionUrl($discussionUrl)
    {
        $this->discussionUrl = $discussionUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiscussionUrl()
    {
        return $this->discussionUrl;
    }

    /**
     * @param $genre
     *
     * @return $this
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param $headline
     *
     * @return $this
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * @param $inLanguage
     *
     * @return $this
     */
    public function setInLanguage($inLanguage)
    {
        $this->inLanguage = $inLanguage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInLanguage()
    {
        return $this->inLanguage;
    }

    /**
     * @param $isBasedOnUrls
     *
     * @return $this
     */
    public function setIsBasedOnUrls($isBasedOnUrls)
    {
        foreach ($isBasedOnUrls as $url) {
            $this->setIsBasedOnUrl($url);
        }

        return $this;
    }

    /**
     * @param $url
     */
    public function setIsBasedOnUrl($url)
    {
        $this->addisBasedOnUrl($url);
    }

    /**
     * @param $url
     */
    public function addIsBasedOnUrl($url)
    {
        if (!$this->isBasedOnUrls->contains($url)) {
            $this->isBasedOnUrls->add($url);
        }
    }

    /**
     * @param $url
     */
    public function removeIsBasedOnUrl($url)
    {
        if ($this->isBasedOnUrls->contains($url)) {
            $this->isBasedOnUrls->removeElement($url);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getIsBasedOnUrls()
    {
        return $this->isBasedOnUrls;
    }

    /**
     * @param $isFamilyFriendly
     *
     * @return $this
     */
    public function setIsFamilyFriendly($isFamilyFriendly)
    {
        $this->isFamilyFriendly = $isFamilyFriendly;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsFamilyFriendly()
    {
        return $this->isFamilyFriendly;
    }

    /**
     * @param $keywords
     * @return $this
     */
    public function setKeywords($keywords)
    {
        foreach ($keywords as $keyword) {
            $this->setKeyword($keyword);
        }

        return $this;
    }

    /**
     * @param $keyword
     * @return $this
     */
    public function setKeyword($keyword)
    {
        $this->addKeyword($keyword);

        return $this;
    }

    /**
     * @param $keyword
     * @return $this
     */
    public function addKeyword($keyword)
    {
        if (!$this->keywords->contains($keyword)) {
            $this->keywords->add($keyword);
        }

        return $this;
    }

    /**
     * @param $keyword
     * @return $this
     */
    public function removeKeyword($keyword)
    {
        if ($this->keywords->contains($keyword)) {
            $this->keywords->removeElement($keyword);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param $mentions
     *
     * @return $this
     */
    public function setMentions($mentions)
    {
        foreach ($this->mentions as $mention) {
            $this->setMention($mention);
        }

        return $this;
    }

    /**
     * @param $mention
     */
    public function setMention($mention)
    {
        $this->addMention($mention);
    }

    /**
     * @param $mention
     */
    public function addMention($mention)
    {
        if (!$this->mentions->contains($mention)) {
            $this->mentions->add($mention);
        }
    }

    /**
     * @param $mention
     */
    public function removeMention($mention)
    {
        if ($this->mentions->contains($mention)) {
            $this->mentions->removeElement($mention);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getMentions()
    {
        return $this->mentions;
    }

    /**
     * @param $provider
     *
     * @return $this
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * @param $provider
     *
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param $publisher
     *
     * @return $this
     */
    public function setPublisher($publisher)
    {
        $this->$publisher = $publisher;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param $thumbnailUrl
     *
     * @return $this
     */
    public function setThumbnailUrl($thumbnailUrl)
    {
        $this->thumbnailUrl = $thumbnailUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getThumbnailUrl()
    {
        return  $this->thumbnailUrl;
    }

    /**
     * @param $version
     *
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param $articleBody
     *
     * @return $this
     */
    public function setArticleBody($articleBody)
    {
        $this->articleBody = $articleBody;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticleBody()
    {
        return $this->articleBody;
    }

    /**
     * @param $articleSection
     *
     * @return $this
     */
    public function setArticleSection($articleSection)
    {
        $this->articleSection = $articleSection;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticleSection()
    {
        return $this->articleSection;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}
