<?php

namespace App\CallRailService;

use App\CallRailService\Foundation\CallRailSetup;

class CallRail extends CallRailSetup
{
    public function calls()
    {
        $this->route = $this->url('/calls.json');
        return $this;
    }

    public function users()
    {
        $this->route = $this->url('/users.json');
        return $this;
    }

    public function company()
    {
        $this->route = $this->url('/companies.json');
        return $this;
    }

    public function source()
    {
        $this->route = $this->url('/trackers.json');
        $this->paramsArr['type'] = 'source';
        return $this;
    }

    public function session()
    {
        $this->route = $this->url('/trackers.json');
        $this->paramsArr['type'] = 'session';
        return $this;
    }
}
