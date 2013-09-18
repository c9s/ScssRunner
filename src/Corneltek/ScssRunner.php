<?php
namespace Corneltek;

class ScssRunner 
{

    const VERSION = "1.0.1";

    public $bin = 'scss';

    public $enableCompass = false;

    public $targets = array();

    public $style;

    public $quiet = false;

    public $debug = false;

    public function __construct($bin = null) {
        if ( $bin ) {
            $this->bin = $bin;
        }
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
        return $cmd;
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

    public function watch($force = false) 
    {
        $cmd = $this->buildBaseCommand($force);
        $cmd[] = '--watch';
        $cmd = array_merge($cmd, $this->buildTargetList());

        // TODO: use symfony process builder 
        system( join(" ", $cmd) );
    }

}

class SassRunner extends ScssRunner {
    public $bin = 'sass';
}

