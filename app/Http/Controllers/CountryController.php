<?php

namespace App\Http\Controllers;

use App\Country;

/**
 * Class CountryController
 * @package App\Http\Controllers
 */
class CountryController extends Controller
{
    /**
     * CountryController constructor.
     * @param ApiResponse $api
     * @param Country $model
     */
    public function __construct(ApiResponse $api, Country $model)
    {
        parent::__construct($api);
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return $this->api->resourceFound($this->model->all());
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function provinces($id)
    {
        $country = $this->model->find($id);
        if (!$country) {
            return $this->api->resourceNotfound();
        }
        return $this->api->resourceFound($country->provinces);
    }
}
