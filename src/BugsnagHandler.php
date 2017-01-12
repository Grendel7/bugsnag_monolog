<?php

namespace i7grendel\BugsnagMonolog;

use Bugsnag\Client;
use Bugsnag\Report;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class BugsnagHandler extends AbstractProcessingHandler
{
    /**
     * @var \Bugsnag\Client
     */
    protected $bugsnag;

    public function __construct(Client $bugsnag, $level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->bugsnag = $bugsnag;
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  array $record
     * @return void
     */
    protected function write(array $record)
    {
        $this->bugsnag->notifyError($record['message'], $record['message'], function (Report $report) use ($record) {
            $report->setSeverity(strtolower($record['level_name']));
            $report->setMetaData($record['context']);
        });
    }
}