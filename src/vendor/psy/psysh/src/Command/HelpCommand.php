<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2023 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Command;

use Psy\Output\ShellOutput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Help command.
 *
 * Lists available commands, and gives command-specific help when asked nicely.
 */
class HelpCommand extends Command
{
    private ?Command $command = null;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('help')
            ->setAliases(['?'])
            ->setDefinition([
                new InputArgument('command_name', InputArgument::OPTIONAL, 'The command name.', null),
            ])
            ->setDescription('Show a list of commands. Type `help [foo]` for information about [foo].')
            ->setHelp('My. How meta.');
    }

    /**
     * Helper for setting a subcommand to retrieve help for.
     *
     * @param Command $command
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;
    }

    /**
     * {@inheritdoc}
     *
     * @return int 0 if everything went fine, or an exit code
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->command !== null) {
            // help for an individual command
            $output->page($this->command->asText());
            $this->command = null;
        } elseif ($name = $input->getArgument('command_name')) {
            // help for an individual command
            $output->page($this->getApplication()->get($name)->asText());
        } else {
            // list available commands
            $commands = $this->getApplication()->all();

            $table = $this->getTable($output);

            foreach ($commands as $name => $command) {
                if ($name !== $command->getName()) {
                    continue;
                }

                if ($command->getAliases()) {
                    $aliases = \sprintf('<comment>Aliases:</comment> %s', \implode(', ', $command->getAliases()));
                } else {
                    $aliases = '';
                }

                $table->addRow([
                    \sprintf('<info>%s</info>', $name),
                    $command->getDescription(),
                    $aliases,
                ]);
            }

            if ($output instanceof ShellOutput) {
                $output->startPaging();
            }

            $table->render();

            if ($output instanceof ShellOutput) {
                $output->stopPaging();
            }
        }

        return 0;
    }
}
