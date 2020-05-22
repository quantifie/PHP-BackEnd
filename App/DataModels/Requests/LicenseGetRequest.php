<?php


namespace  App\DataModels\Requests;



class LicenseGetRequest
{
    public int $Id;
    public bool $IncludeSubLicenses;
}