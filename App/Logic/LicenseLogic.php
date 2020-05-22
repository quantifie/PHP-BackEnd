<?php

namespace App\Logic;

use App\ApplicationDbContext;
use App\DatabaseModels\License;
use Core\Database\DbContext;
use Core\Database\Enums\KeyValueOperators;
use Core\Database\Enums\SelectResultTypes;
use Core\Database\TableActionContainers\IncludeTableData;
use Core\Libs\Helpers\DateTime;
use Core\Libs\Helpers\Debug;
use Core\Libs\Helpers\Mapper;
use Core\Security\Token;

/**
 * Class LicenseLogic
 */
class LicenseLogic
{
    /**
     * @var DbContext
     */
    private DbContext $_context;

    /**
     * LicenseLogic constructor.
     * @param DbContext $context
     */
    public function __construct()
    {
        $this->_context = new ApplicationDbContext();
    }

    /**
     * @param License $license
     * @return null|License
     */
    public function Add(License $license)
    {
        $addLicense = $this->_context->Licenses->Insert([
            "Active" => $license->Active,
            "CreationDate" => DateTime::Now(),
            "Type" => 0,
            "ManagerId" => $license->ManagerId,
            "Deleted" => 0,
            "Count" => $license->Count,
            "SubscriptionStartDate" => DateTime::Convert($license->SubscriptionStartDate, "d/m/Y", "Y-m-d"),
            "SubscriptionEndDate" => DateTime::Convert($license->SubscriptionEndDate, "d/m/Y", "Y-m-d"),
            "LicenseeId" => $license->LicenseeId,
            "LicenseToken" => Token::Create(256)
        ]);

        if (isset($addLicense))
            return null;

        return Mapper::Map($addLicense, License::class, true);
    }

    /**
     * @param int $id
     * @param bool $includeSubLicenses
     * @return false|License
     */
    public function Get(int $id, bool $includeSubLicenses)
    {
        $includeSubLicenseObject = [new IncludeTableData("Licensees", "Id", "Licensee", "LicenseeId", false, SelectResultTypes::$Single, [], [
            new IncludeTableData("Departments", "Id", "Department", "DepartmentId", false, SelectResultTypes::$Single)
        ])];
        if ($includeSubLicenses) {
            $includeSubLicenseObject = [new IncludeTableData("Licenses",
                "ManagerId",
                "SubLicenses", "Id",
                true,
                SelectResultTypes::$List, [], [
                    new IncludeTableData("Licensees", "Id", "Licensee", "LicenseeId", false, SelectResultTypes::$Single, [], [
                        new IncludeTableData("Departments", "Id", "Department", "DepartmentId", false, SelectResultTypes::$Single)
                    ])
                ]),
                new IncludeTableData("Licensees", "Id", "Licensee", "LicenseeId", false, SelectResultTypes::$Single, [], [
                    new IncludeTableData("Departments", "Id", "Department", "DepartmentId", false, SelectResultTypes::$Single)
                ])
            ];
        }

        $license = $this->_context->Licenses->Select([], $includeSubLicenseObject)
            ->Where("Id", KeyValueOperators::$Equal, $id)
            ->Single();

        return Mapper::Map($license, License::class, true);
    }
}