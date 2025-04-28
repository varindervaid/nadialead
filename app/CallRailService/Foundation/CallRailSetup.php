<?php

namespace App\CallRailService\Foundation;
use App\Exceptions\CallRailException;
use Illuminate\Support\Facades\Http;

abstract class CallRailSetup
{
    private string $api_url;
    private string $version;
    private string $accountID;
    private string $headerAuthToken;
    private $http;
    protected $paramsArr = [];
    protected $route;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->api_url = config('callrail.api_url');
        $this->accountID = config('callrail.account_id');
        $this->version = config('callrail.version');
        $this->headerAuthToken = "Token token=".config('callrail.token');

        $this->http = Http::withHeaders([
            'Authorization' => "$this->headerAuthToken"
        ]);
    }

    final public function url($path = '')
    {
        $root = rtrim($this->api_url, '/') . '/'. $this->version . '/a/'. $this->accountID .'/';
        return $root. ltrim($path, '/');
    }

    final public function routeUrl()
    {
        if(!$this->route) {
            throw new CallRailException("Route is not defined. please add function ->calls()|->users()|->company()");
        }
        return $this->route;
    }

    final public function select(...$select)
    {
        if(count($select) == 1) {
            $this->paramsArr['fields'] = implode(',', $select[0]);
        } elseif(count($select) > 1) {
            $this->paramsArr['fields'] = implode(',', $select);
        }
        return $this;
    }

    final public function where(array $params = [])
    {
        $this->paramsArr = [...$params, ...$this->paramsArr];
        return $this;
    }

    final public function get()
    {
        $this->routeUrl();

        $response = $this->http->get(
            $this->route,
            $this->paramsArr
        );

        if ($response->successful()) {
            return $response->json();
        } elseif ($response->failed()) {
            return $response->body();
        }
    }

    final public function paginate($perPage, $offset = 0)
    {
        $this->routeUrl();

        $params = [...$this->paramsArr, ...[
            'relative_pagination' => 'true',
            'per_page' => $perPage,
            'offset' => $offset
        ]];

        $response = $this->http->get(
            $this->route,
            $params
        );

        if ($response->successful()) {
            return $response->json();
        } elseif ($response->failed()) {
            return $response->body();
        }
    }
}
