<?php

namespace App;

class ApplicationVersion
{
    private static $instance;

    private $commitHash, $shortHash, $tag;

    public function __construct()
    {
        $this->shortHash = trim(exec('git log --pretty="%h" -n1 HEAD'));
        $this->commitHash = trim(exec('git log --pretty="%H" -n1 HEAD'));

        $rawTag = trim(exec('git describe --tags --abbrev=0 2>&1'));

        if (\strpos($rawTag, 'fatal') === false) {
            $this->tag = $rawTag;
        }
    }

    public function get()
    {
        $value = $this->shortHash;

        if ($this->tag) {
            $value = $this->tag . ' (' . $this->shortHash . ')';
        }

        return $value;
    }

    public function getLongHash() {
        return $this->commitHash;
    }

    /**
     * @return ApplicationVersion
     */
    public static function instance() {
        if (!ApplicationVersion::$instance) {
            ApplicationVersion::$instance = new ApplicationVersion();
        }

        return ApplicationVersion::$instance;
    }
}
