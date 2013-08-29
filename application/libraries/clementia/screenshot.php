<?php

namespace Clementia;

class Screenshot
{
    private $url = null;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function capture()
    {
        $cmd = \Config::get('tests.screenshot.command');

        $filename = sha1($this->url.microtime()) . '.jpg';
        $fullPath = path('screenshots') . $filename;

        $cmd = sprintf($cmd, escapeshellarg($this->url), escapeshellarg($fullPath));

        $returnVal = 0;
        $output = array();
        exec($cmd . " 2>&1", $output, $returnVal);

        if ((int)$returnVal === 0) {
            return $filename;
        } else {
            throw new \Exception("Unable to create screenshot");
        }
    }
}