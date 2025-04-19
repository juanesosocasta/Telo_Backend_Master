<?php

namespace App\Http\Requests;

use App\Http\Controllers\StatusCode;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Request
 * @package App\Http\Requests
 */
abstract class Request extends FormRequest
{
    /**
     * function used by response bad request with errors
     * @param array $errors
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        if (count($errors) > 0) {
            return response($errors, StatusCode::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @return bool
     */
    public function ajax()
    {
        return true;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public abstract function rules();
}
