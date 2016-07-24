<?php

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class BugsnagHandler extends AbstractProcessingHandler
{
    /**
     * @var \Bugsnag_Client
     */
    protected $bugsnag;

    public function __construct(\Bugsnag_Client $bugsnag, $level = Logger::DEBUG, $bubble = true)
    {
        $this->bugsnag = $bugsnag;

        parent::__construct($level, $bubble);
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  array $record
     * @return void
     */
    protected function write(array $record)
    {
        $this->bugsnag->notifyError($record['message'], $record['message'], $record['context'], strtolower($record['level_name']));
    }
}