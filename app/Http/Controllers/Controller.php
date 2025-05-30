<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Tawseel API Documentation",
 *     description="API documentation for Tawseel food delivery application",
 *     @OA\Contact(
 *         email="admin@example.com",
 *         name="API Support"
 *     )
 * )
 *
 * @OA\Server(
 *     url="https://tawseel.circleteams.com/",
 *     description="Local Development Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *
 * @OA\PathItem(
 *     path="/api"
 * )
 */
abstract class Controller
{
    //
}

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Tawseel API Documentation",
 *     description="API documentation for Tawseel food delivery application",
 *     @OA\Contact(
 *         email="admin@example.com",
 *         name="API Support"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local Development Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
