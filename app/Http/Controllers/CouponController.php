<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Support\Facades\Auth as Auth;

class CouponController extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function allByCustomer()
    {
        $establisments = Auth::user()->establishments;
        if (!$establisments) {
            return $this->api->resourceNotfound();
        }
        $ids = array_pluck($establisments, 'id');
        $coupons = Coupon::whereIn('establishment_id', $ids)->get();
        return $this->api->resourceFound($coupons);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $coupons = Coupon::with('establishment')->get();
        return $this->api->resourceFound($coupons);
    }
}
