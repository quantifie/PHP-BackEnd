<?php


namespace Core\Options;


interface IApplicationOption
{
    public function IsDevelopment(): bool;

    public function ReportErrors(): bool;

    public function FilterOrigins(): bool;

    public function EnableMigration(): bool;

    public function UploadSize(): int;
}