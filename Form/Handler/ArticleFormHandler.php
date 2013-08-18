<?php

/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\ArticleBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Black\Bundle\ArticleBundle\Model\ArticleInterface;

/**
 * Class ArticleFormHandler
 *
 * @package Black\Bundle\ArticleBundle\Form\Handler
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class ArticleFormHandler
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;
    /**
     * @var \Symfony\Component\Form\FormInterface
     */
    protected $form;
    /**
     * @var
     */
    protected $factory;
    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * @param FormInterface    $form
     * @param Request          $request
     * @param SessionInterface $session
     */
    public function __construct(FormInterface $form, Request $request, SessionInterface $session)
    {
        $this->form     = $form;
        $this->request  = $request;
        $this->session  = $session;
    }

    /**
     * @param ArticleInterface $article
     *
     * @return bool
     */
    public function process(ArticleInterface $article)
    {
        $this->form->setData($article);

        if ('POST' === $this->request->getMethod()) {

            $this->form->bind($this->request);

            if ($this->form->isValid()) {

                $this->setFlash('success', ' success.article.admin.article.edit');

                return true;
            } else {
                $this->setFlash('error', 'error.article.admin.article.not.valid');
            }
        }
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param $name
     * @param $msg
     * @return mixed
     */
    protected function setFlash($name, $msg)
    {
        return $this->session->getFlashBag()->add($name, $msg);
    }
}
