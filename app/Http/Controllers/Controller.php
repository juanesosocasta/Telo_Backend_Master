<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $input;

    /**
     * @var ApiResponse
     */
    protected $api;

    /**
     * Controller constructor.
     * @param ApiResponse $api
     */
    public function __construct(ApiResponse $api)
    {
        $this->api = $api;
        $this->input = Request::capture()->all();
    }

    /**
     * @return array
     */
    public function getModel()
    {
        return $this->model->toArray();
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return $this->api->resourceFound($this->model->all());
    }

    /**
     * @param $query
     * @return mixed
     */
    public function executeQuery($query)
    {
        return DB::select($query, []);
    }

    /**
     * @param $resultSet
     * @return mixed
     */
    public function decodeFirstElementFromResultSet($resultSet)
    {
        return json_decode(json_encode($resultSet[0]), true);
    }

    /**
     * @return mixed
     */
    public function total()
    {
        return $this->model->count();
    }
}
