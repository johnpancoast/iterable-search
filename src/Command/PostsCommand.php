<?php
/**
 * @package       johnpancoast/code-challenge
 * @copyright (c) 2016 John Pancoast
 * @license       Public Domain
 */

namespace Pancoast\CodeChallenge\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Console command allowing you o iterate over posts and get different information about them.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class PostsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName("posts")
            ->setDescription("Iterate over posts and get different information about them")
            ->addArgument(
                "input_file",
                InputArgument::OPTIONAL,
                "A file providing posts for input"
            )
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // TODO
    }
}
