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

/**
 * Class ArticleInterface
 *
 * @package Black\Bundle\ArticleBundle\Model
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
interface ArticleInterface
{
    /**
     * @return mixed
     */
    public function getAlternativeHeadline();

    /**
     * @return mixed
     */
    public function getAuthor();

    /**
     * @return mixed
     */
    public function getComments();

    /**
     * @return mixed
     */
    public function getContentLocation();

    /**
     * @return mixed
     */
    public function getContentRating();

    /**
     * @return mixed
     */
    public function getContributors();

    /**
     * @return mixed
     */
    public function getCopyrightHolder();

    /**
     * @return mixed
     */
    public function getCopyrightYear();

    /**
     * @return mixed
     */
    public function getDatePublished();

    /**
     * @return mixed
     */
    public function getDiscussionUrl();

    /**
     * @return mixed
     */
    public function getGenre();

    /**
     * @return mixed
     */
    public function getHeadline();

    /**
     * @return mixed
     */
    public function getInLanguage();

    /**
     * @return mixed
     */
    public function getIsBasedOnUrls();

    /**
     * @return mixed
     */
    public function getIsFamilyFriendly();

    /**
     * @return mixed
     */
    public function getKeywords();

    /**
     * @return mixed
     */
    public function getMentions();

    /**
     * @return mixed
     */
    public function getProvider();

    /**
     * @return mixed
     */
    public function getPublisher();

    /**
     * @return mixed
     */
    public function getThumbnailUrl();

    /**
     * @return mixed
     */
    public function getVersion();

    /**
     * @return mixed
     */
    public function getArticleBody();

    /**
     * @return mixed
     */
    public function getArticleSection();
}
