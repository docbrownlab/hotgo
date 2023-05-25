<?php


namespace Tatix\Login\Logger;

use \Magento\Framework\Filesystem\DriverInterface;
use \Magento\Framework\Filesystem;
use \Monolog\Formatter\LineFormatter;
use \Magento\Framework\Stdlib\DateTime\TimezoneInterface ;
use \Monolog\Logger;

class Handler  extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::ERROR;

    /**
     * File name
     * @var string
     */
    protected $fileName = '';

    public function __construct(
        DriverInterface $filesystem,
        Filesystem $corefilesystem,
        TimezoneInterface $localeDate,
        $filePath = null
    ) {
        $this->_localeDate = $localeDate;
        $corefilesystem= $corefilesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR);
        $logpath = $corefilesystem->getAbsolutePath('log/');

        $filename = 'tatixLogin_'.Date('d_m_Y').'.log';

        $filepath = $logpath . $filename;
        $this->cutomfileName=$filepath;

        parent::__construct(
            $filesystem,
            $filepath
        );

        $this->setFormatter(new LineFormatter('%message%'.PHP_EOL,null,true));

    }

}
