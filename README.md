<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Files Location
### Middleware - app/Http/Middleware/RedisSanctumMiddleware.php
Explanation

The RedisSanctumMiddleware is a custom middleware designed to handle authentication using Laravel Sanctum tokens stored in Redis. This middleware improves the performance of token validation by reducing the need for frequent database queries.

The primary purpose of the RedisSanctumMiddleware is to authenticate API requests using tokens stored in Redis. If the token is not found in Redis, it falls back to querying the database and then stores the token information in Redis for future requests.

How It Works
- Retrieve Token: The middleware retrieves the bearer token from the request.
- Check Redis: It checks if the token data is stored in Redis.
- Fallback to Database: If the token data is not found in Redis, it queries the database for the token.
- Store in Redis: The token data is then stored in Redis for future requests.
- Set User Resolver: The middleware sets the user resolver using the token data.
- Proceed with Request: The request proceeds to the next middleware or controller.

### Routes - routes/api.php 
Explanation

- Route Definition: This route defines a GET request to the /user endpoint.
- Middleware: The route is protected by the auth.redis_sanctum middleware.
- Custom Middleware: The auth.redis_sanctum middleware is a custom middleware that authenticates requests using Laravel Sanctum tokens stored in Redis.
- Request Handling: If the request is authenticated, the middleware allows access to the endpoint, and the authenticated user's information is returned.

How It Works

- Middleware Application: The auth.redis_sanctum middleware is applied to the /user endpoint.
- Token Validation: The middleware retrieves the bearer token from the request and checks if the token data is stored in Redis.
- Fallback to Database: If the token data is not found in Redis, the middleware queries the database for the token and stores the token data in Redis for future requests.
- User Retrieval: If the token is valid, the middleware sets the - user resolver, and the authenticated user's information is returned by the route.

### Kernel - app/Http/Kernel.php
In the Kernel.php file, we have registered a custom middleware called auth.redis_sanctum. This middleware is responsible for handling authentication using Redis to store and retrieve Sanctum tokens. By using Redis, we can improve the performance of token validation by avoiding frequent database queries.
    