<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;


  #[OA\Info(
      title:"MAROC EXPLORER API",
      version:"1.0.0",
      description:"This is the API documentation for the MAROC EXPLORER API. It handles webhook requests and responses, allowing users to generate and display data dynamically."
   )]
  #[OA\SecurityScheme(
      securityScheme: 'sanctum',
      type: 'http',
      scheme: 'bearer',
      bearerFormat: 'JWT',
  )]

abstract class Controller
{
    // 
}
