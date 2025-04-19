<?php

namespace App\Http\Controllers;

use App\Province;

/**
 * Class ProvinceController
 * @package App\Http\Controllers
 */
class ProvinceController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function cities($id)
    {
        $province = Province::find($id);
        if (!$province) {
            return $this->api->resourceNotfound();
        }
        return $this->api->resourceFound($province->cities);
    }
}
