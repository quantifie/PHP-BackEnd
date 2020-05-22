<?php

namespace Core\Options;

use Core\Exceptions\NoApplicationOptionException;
use Exception;

/**
 * Class ApplicationConfig
 * @package Options
 */
class ApplicationOption implements IApplicationOption
{
    #region Public Fields
    /**
     * @var bool
     * Determines if the environment type is development or production
     */
    private ?bool $_isDevelopment = false;

    /**
     * @var bool|null
     * Enable/Disable Reports
     */
    private bool $_reportErrors = true;

    /**
     * @var bool
     * Enable/Disable Migrations
     */
    private ?bool $_enableMigration = false;

    /**
     * @var bool
     */
    private bool $_filterOrigins = true;

    private int $_uploadSizeInMb = 256;
    #endregion

    #endregion

    #region Constructor
    /**
     * ApplicationConfig constructor.
     * @param bool $isDevelopment
     * @param bool $enableMigration
     * @param bool $reportErrors
     * @param bool $filterOrigins
     * @param int $uploadSizeInMb
     */
    public function __construct(
        bool $isDevelopment = null,
        bool $enableMigration = null,
        bool $reportErrors = true,
        bool $filterOrigins = true,
        int $uploadSizeInMb = 4)
    {
        try {
            if (isset($isDevelopment))
                $this->_enableMigration = $enableMigration;

            if (isset($enableMigration))
                $this->_isDevelopment = $isDevelopment;

            $this->_reportErrors = $reportErrors;
            $this->_filterOrigins = $filterOrigins;
            $this->_uploadSizeInMb = $uploadSizeInMb;
        } catch (Exception $e) {
            new NoApplicationOptionException();
        }

    }
    #endregion

    #region Public Methods
    public function IsDevelopment(): bool {
        return $this->_isDevelopment;
    }

    public function ReportErrors(): bool {
        return $this->_reportErrors;
    }

    public function FilterOrigins(): bool {
        return $this->_filterOrigins;
    }

    public function EnableMigration(): bool {
        return $this->_enableMigration;
    }

    public function SetEnableMigration(int $enableMigration) {
        $this->_enableMigration = $enableMigration;
    }

    public function UploadSize(): int {
        return $this->_uploadSizeInMb;
    }
    #endregion

    #region Private Methods
    #endregion

    #region Helpers
    #endregion
}
