<?php

namespace Xigen\ClearStatic\Console\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\State;
use Magento\Framework\App\State\CleanupFiles;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Clear extends Command
{
    const INPUT_KEY_CLEAR_STATIC_CONTENT = 'clear-static-content';

    /**
     * @var \Magento\Framework\App\ObjectManager
     */
    protected $_objectManager;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;

    /**
     * Clear constructor.
     * @param \Magento\Framework\App\State $state
     */
    public function __construct(
        State $state
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
        $this->state->setAreaCode(Area::AREA_GLOBAL);
        $this->_objectManager = ObjectManager::getInstance();

        if ($input->getOption(self::INPUT_KEY_CLEAR_STATIC_CONTENT)) {
            $ClearupFiles = $this->_objectManager->get(CleanupFiles::class);
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
