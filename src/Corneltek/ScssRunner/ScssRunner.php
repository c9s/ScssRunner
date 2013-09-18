<?php
namespace Corneltek\ScssRunner;

class ScssRunner 
{

    const VERSION = "1.0.3";

    public $bin = 'scss';

    public $enableCompass = false;

    public $targets = array();

    public $style;

    public $quiet = false;

    public $debug = false;

    public $loadPaths = array();

    public function __construct($bin = null) {
        if ( $bin ) {
            $this->bin = $bin;
        }
    }

    public function addLoadPath() {
        $paths = func_get_args();
        $this->loadPaths = array_merge($this->loadPaths, $paths);
        return $this;
    }

    public function setQuiet($quiet = true) {
        $this->quiet = $quiet;
        return $this;
    }


    public function setDebug($debug = true) {
        $this->debug = $debug;
        return $this;
    }

    public function enableCompass($enable = true) {
        $this->enableCompass = $enable;
        return $this;
    }

    public function addTarget($from, $to = null) {
        $this->targets[] = array($from, $to);
        return $this;
    }

    public function setStyle($style) {
        $this->style = $style;
        return $this;
    }

    public function buildBaseCommand($force = false) {
        $cmd = array( $this->bin );
        if ( $this->enableCompass ) {
            $cmd[] = '--compass';
        }
        if ( $force ) {
            $cmd[] = '--force';
        }
        if ( $this->style ) {
            $cmd[] = '--style';
            $cmd[] = $this->style;
        }
        if ( $this->quiet ) {
            $cmd[] = '--quiet';
        }
        if ( $this->debug ) {
            $cmd[] = '-g';
        }

        $cmd = array_merge($cmd, $this->buildLoadPathList());
        return $cmd;
    }

    public function buildLoadPathList() {
        $list = array();
        foreach( $this->loadPaths as $path ) {
            $list[] = '--load-path';
            $list[] = $path;
        }
        return $list;
    }

    public function buildTargetList() {
        $list = array();
        foreach( $this->targets as $target ) {
            list($from, $to) = $target;
            if ( $to ) {
                $list[] = "$from:$to";
            } else {
                $list[] = $from;
            }
        }
        return $list;
    }

    public function update($force = false) 
    {
        $cmd = $this->buildBaseCommand($force);
        $cmd[] = '--update';
        $cmd = array_merge($cmd, $this->buildTargetList());

        // TODO: use symfony process builder 
        system( join(" ", $cmd) );
    }

    public function check() 
    {
        $cmd = $this->buildBaseCommand($force);
        $cmd[] = '--check';
        $cmd = array_merge($cmd, $this->buildTargetList());

        // TODO: use symfony process builder 
        system( join(" ", $cmd) );
    }

    public function watch($force = false) 
    {
        $cmd = $this->buildBaseCommand($force);
        $cmd[] = '--watch';
        $cmd = array_merge($cmd, $this->buildTargetList());

        // TODO: use symfony process builder 
        system( join(" ", $cmd) );
    }

}

