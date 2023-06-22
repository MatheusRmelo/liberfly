<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Swagger(
 *     schemes={"http"},
 *     host=localhost,
 *     basePath="/",
 *     @OA\Server(url=L5_SWAGGER_CONST_HOST),
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Liberfly API",
 *         description="Liberfly API test",
 *         termsOfService="",
 *         @OA\Contact(
 *             email="matheusroberttjmelo@gmail.com"
 *         ),
 *     ),
 *    @OA\PathItem(path="/api")
 *
 *    @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer")
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
