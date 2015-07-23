<?php

/*
 * This file is part of the CrudGeneratorBundle
 *
 * It is based/extended from SensioGeneratorBundle
 *
 * (c) Jordi Llonch <llonch.jordi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itscaro\CrudGeneratorBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Mapping\DisconnectedMetadataFactory;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;


class CrudAllCommand extends ContainerAwareCommand
{
    protected $generator;
    protected $formGenerator;

    protected function configure()
    {
        parent::configure();

        $this->setName('itscaro:generate:all');
        $this->setDefinition(array(
            new InputArgument('bundle', InputArgument::REQUIRED, 'Bundle name'),
            new InputOption('route-prefix', '', InputOption::VALUE_REQUIRED, 'The route prefix'),
            new InputOption('with-write', '', InputOption::VALUE_NONE, 'Whether or not to generate create, new and delete actions'),
            new InputOption('format', '', InputOption::VALUE_REQUIRED, 'Use the format for configuration files (php, xml, yml, or annotation)', 'annotation'),
            new InputOption('overwrite', '', InputOption::VALUE_NONE, 'Do not stop the generation if crud controller already exist, thus overwriting all generated files'),
        ));
        $this->setDescription('A CRUD generator with paginating and filters.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->isEnabled()) {
            $bundleName = $input->getArgument("bundle");
            $bundle = $this->getContainer()->get('kernel')->getBundle($bundleName);
            /* @var $bundle BundleInterface */

            $entities = array();
            foreach ($this->getBundleMetadata($bundle) as $m) {
                /* @var $m ClassMetadata */
                $_tmp = explode('\\', $m->getName());
                $entities[] = $bundleName . ':' . array_pop($_tmp);
            }

            $command = $this->getApplication()->find('itscaro:generate:crud');
            foreach ($entities as $entity) {
                try {
                    $_input = new ArrayInput([
                        'command' => 'itscaro:generate:crud',
                        '--entity' => $entity,
                        '--route-prefix' => $input->getOption('route-prefix'),
                        '--with-write' => $input->getOption('with-write'),
                        '--format' => $input->getOption('format'),
                        '--overwrite' => $input->getOption('overwrite'),
                    ]);
                    $_input->setInteractive($input->isInteractive());
                    $output->writeln("<info>Executing:</info> $_input");
                    $returnCode = $command->run($_input, $output);
                    $output->writeln("\t<info>Done</info>");
                } catch (\Exception $e) {
                    $output->writeln("\t<error>Error:</error> " . $e->getMessage());
                }
            }
        } else {
            $output->writeln('<error>Cannot find DoctrineBundle</error>');
        }
    }

    public function isEnabled()
    {
        return class_exists('Doctrine\\Bundle\\DoctrineBundle\\DoctrineBundle');
    }

    protected function getBundleMetadata(BundleInterface $bundle)
    {
        $factory = new DisconnectedMetadataFactory($this->getContainer()->get('doctrine'));

        return $factory->getBundleMetadata($bundle)->getMetadata();
    }
}
