<?php

namespace SaadSaif\OrderExport\Cron;

use \SaadSaif\OrderExport\Action\ArchiveExportDetails as ArchiveExportDetailsAction;
class ArchiveExportDetails
{
    private ArchiveExportDetailsAction $archiveExportDetails;

    public function __construct(
        ArchiveExportDetailsAction $archiveExportDetails
    ) {
        $this->archiveExportDetails = $archiveExportDetails;
    }

    /**
     * @throws \Exception
     */
    public function execute(): void
    {
        $this->archiveExportDetails->execute();
    }
}
