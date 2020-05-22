<?php


namespace Core\Entities;


/**
 * Class ErrorCodes
 * @package Entities
 */
class ErrorCodes
{
    public static int $RequestTypeMismatch = 1000;
    public static int $Connection = 1001;
    public static int $Migration = 1002;
    public static int $UrlParse = 1003;
    public static int $RouteNotFound = 1005;
    public static int $RecordNotFound = 1006;
    public static int $RecordNotUpdated = 1007;
    public static int $RecordNotAdded = 1008;
    public static int $RecordNotDeleted = 1009;
    public static int $ManagerUserNameNotMatched = 1010;
    public static int $ManagerPasswordNotMatched = 1011;
    public static int $ManagerAccountIsNotActive = 1012;

    public static int $RequestObjectRequirements = 2001;
    public static int $NoLicenseFound = 2002;
    public static int $LicenseNotActive = 2003;
    public static int $LicenseAlreadyActivated = 2007;
    public static int $LicenseNotDeleted = 2008;
    public static int $LicenseNotUpdated = 2009;
    public static int $LicenseAlreadyDeactivated = 2010;
    public static int $LicenseNotReverted = 2011;
    public static int $SubscriptionEnded = 2012;
    public static int $RequestBodyNotFound = 2004;
    public static int $RequirementsNotPresented = 2005;
    public static int $FileNotUploaded = 2006;

    public static int $RequestDidNotSuccess = 3001;
    public static int $FileSizeExceeded = 3002;
    public static int $ReleaseNoteNotAdded = 3003;
    public static int $ReleaseBulletNotAdded = 3004;
    public static int $LauncherUpdateNotAdded = 3005;
    public static int $LauncherUpdateNotPublished = 3006;
    public static int $MetropolisUpdateNotAdded = 3007;
    public static int $LauncherEventNotAdded = 3008;
    public static int $LauncherEventNotFound = 3009;
    public static int $LauncherEventNotUpdated = 3010;
    public static int $LauncherEventNotDeleted = 3011;
    public static int $NoNewVersionFound = 3012;

    public static int $ReflectionClassNotCreated = 10000;
    public static int $ReflectionMethodNotFound = 10001;
    public static int $ReflectionPropertyNotFound = 10002;

}
