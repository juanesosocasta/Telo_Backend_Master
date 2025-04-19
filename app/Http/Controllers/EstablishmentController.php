<?php

namespace App\Http\Controllers;

use App\Establishment;
use App\Http\Requests\EstablishmentRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class EstablishmentController
 * @package App\Http\Controllers
 */
class EstablishmentController extends Controller
{

    /**
     * EstablishmentController constructor.
     * @param ApiResponse $api
     * @param Establishment $model
     */
    public function __construct(ApiResponse $api, Establishment $model)
    {
        parent::__construct($api);
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Http\Response
     */
        public function allByCustomer()
    { $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401); // Usuario no autenticado
        }
    
        $user->load(['establishments.city']); // Carga relaciones
    
        if ($user->establishments->isEmpty()) {
            return $this->api->resourceNotfound();
        }
    
        return $this->api->resourceFound($user->establishments);
    }

    /**
     * @param EstablishmentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstablishmentRequest $request)
    {
        $this->model->fill($this->input);
        $this->model->customer_id = Auth::user()->id;
        $this->model->save();
        return $this->api->objectCreated($this->model->toArray());
    }
}
