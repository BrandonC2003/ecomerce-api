<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'E-commerce API  ',
    description: 'API para la gestión de productos en un sistema de comercio electrónico.',
)]
#[OA\Server(
    url: 'http://localhost:8000/api',
    description: 'Servidor local'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'Token JWT en formato Bearer'
)]
#[OA\Schema(
    schema: 'AuthData',
    properties: [
        new OA\Property(property: 'token', type: 'string', example: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...'),
        new OA\Property(property: 'token_type', type: 'string', example: 'bearer'),
        new OA\Property(property: 'expires_in', type: 'integer', example: 3600),
        new OA\Property(property: 'user', ref: '#/components/schemas/User'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ApiSuccessResponse',
    required: ['success', 'message'],
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'message', type: 'string', example: 'Operación exitosa.'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ApiErrorResponse',
    required: ['success', 'message', 'errors'],
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'message', type: 'string', example: 'Ocurrió un error.'),
        new OA\Property(property: 'errors', type: 'object', additionalProperties: true),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'PaginationMeta',
    properties: [
        new OA\Property(property: 'current_page', type: 'integer', example: 1),
        new OA\Property(property: 'from', type: 'integer', nullable: true, example: 1),
        new OA\Property(property: 'last_page', type: 'integer', example: 5),
        new OA\Property(property: 'per_page', type: 'integer', example: 10),
        new OA\Property(property: 'to', type: 'integer', nullable: true, example: 10),
        new OA\Property(property: 'total', type: 'integer', example: 50),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'PaginationLinks',
    properties: [
        new OA\Property(property: 'first', type: 'string', format: 'uri', nullable: true),
        new OA\Property(property: 'last', type: 'string', format: 'uri', nullable: true),
        new OA\Property(property: 'previous', type: 'string', format: 'uri', nullable: true),
        new OA\Property(property: 'next', type: 'string', format: 'uri', nullable: true),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'AuthResponse',
    allOf: [new OA\Schema(ref: '#/components/schemas/ApiSuccessResponse')],
    properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/AuthData'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ProductResponse',
    allOf: [new OA\Schema(ref: '#/components/schemas/ApiSuccessResponse')],
    properties: [
        new OA\Property(property: 'data', ref: '#/components/schemas/Product'),
    ],
    type: 'object'
)]
#[OA\Schema(
    schema: 'ProductListResponse',
    allOf: [new OA\Schema(ref: '#/components/schemas/ApiSuccessResponse')],
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/Product')
        ),
        new OA\Property(property: 'meta', ref: '#/components/schemas/PaginationMeta'),
        new OA\Property(property: 'links', ref: '#/components/schemas/PaginationLinks'),
    ],
    type: 'object'
)]
abstract class Controller
{
    //
}
