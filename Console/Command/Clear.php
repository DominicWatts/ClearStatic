<?php


namespace Xigen\ClearStatic\Console\Command;

use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Clear
 * @package Xigen\ClearStatic\Console\Command
 */
class Clear extends Command
{
    const INPUT_KEY_CLEAR_STATIC_CONTENT = 'clear-static-content';

    /**
     * @var \Magento\Framework\App\ObjectManager
     */
    protected $_objectManager;

    /**
     * Clear constructor.
     * @param \Magento\Framework\App\State $state
     */
    public function __construct(
        \Magento\Framework\App\State $state
    ) {
        $this->state = $state;
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws LocalizedException
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        if ($input->getOption(self::INPUT_KEY_CLEAR_STATIC_CONTENT)) {
            $ClearupFiles = $this->_objectManager->get(\Magento\Framework\App\State\CleanupFiles::class);
            $ClearupFiles->clearMaterializedViewFiles();
            $output->writeln('<info>Generated static view files cleared successfully.</info>');
        } else {
            throw new LocalizedException(__(
                "To clear static view files run %1 with the -- %2 option to clear them.'",
                $this->getName(),
                self::INPUT_KEY_CLEAR_STATIC_CONTENT
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("xigen:clearstatic:clear");
        $this->setDescription("Clear static content");
        $this->addOption(
            self::INPUT_KEY_CLEAR_STATIC_CONTENT,
            'c',
            InputOption::VALUE_NONE,
            'Clear generated static view files.'
        );
        parent::configure();
    }
}
