<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\ArticleBundle\Command;

use Black\Bundle\ConfigBundle\Model\ConfigManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class InstallArticleCommand
 *
 * @package Black\Bundle\ArticleBundle\Command
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class InstallArticleCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('black:article:install')
            ->setDescription('Create needed object for your orm/odm');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager    = $this->getManager();
        $output->writeln('<comment>First step: Create article parameter</comment>');

        $result   = $this->createArticle($manager, $output);
        $output->writeln($result);


        $manager->flush();

    }

    /**
     * @param ConfigManagerInterface $manager
     * @param OutputInterface        $output
     *
     * @return string
     */
    private function createArticle(ConfigManagerInterface $manager, OutputInterface $output)
    {
        if ($manager->findPropertyByName('Article')) {
            return '<error>The property Article already exist!</error>';
        }

        $object = $manager->createInstance();
        $value  = array();

        $dialog = $this->getHelperSet()->get('dialog');


        $protected = $this->createProtected($dialog, $output);
        $value += array('article_protected' => $protected);

        $rss    = $this->createFeed($dialog, $output);
        $value += array('article_rss' => $rss);

        $view   = $this->createView($dialog, $output);
        $value += array('article_max' => $view);

        $object
            ->setName('Article')
            ->setValue($value)
            ->setProtected(true);

        $manager->persist($object);

        return '<info>The property Article was created!</info>';
    }

    /**
     * @param                 $dialog
     * @param OutputInterface $output
     *
     * @return string
     */
    private function createProtected($dialog, OutputInterface $output)
    {
        $protected = $dialog->askConfirmation($output,
            '<question>Do you want to active article protection? (y/n, default: n)</question>',
            false
        );

        if ($protected == true) {
            return "true";
        }

        return "false";
    }

    /**
     * @param                 $dialog
     * @param OutputInterface $output
     */
    private function createFeed($dialog, OutputInterface $output)
    {
        $validator = function ($value) {
            if ('' === trim($value)) {
                throw new \Exception('The value can not be empty');
            }

            if (!is_numeric($value)) {
                throw new \Exception('The value must be a number');
            }

            return $value;
        };

        $article = $dialog->askAndValidate(
            $output,
            'Number of articles in your feed? ',
            $validator
        );

        return $article;
    }

    /**
     * @param                 $dialog
     * @param OutputInterface $output
     */
    private function createView($dialog, OutputInterface $output)
    {
        $validator = function ($value) {
            if ('' === trim($value)) {
                throw new \Exception('The value can not be empty');
            }

            if (!is_numeric($value)) {
                throw new \Exception('The value must be a number');
            }

            return $value;
        };

        $article = $dialog->askAndValidate(
            $output,
            'Number of articles per views? ',
            $validator
        );

        return $article;
    }

    /**
     * @return object
     */
    private function getManager()
    {
        return $this->getContainer()->get('black_config.manager.config');
    }
}
