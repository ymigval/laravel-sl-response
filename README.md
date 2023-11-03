# ymigval/laravel-sl-response

The `ymigval/laravel-sl-response` package simplifies API response management in Laravel applications. It allows you to structure and format API responses with ease, ensuring consistency and adherence to API standards.

### Key Features

- **Consistent Responses**: Generate API responses with a standardized structure, including status codes, messages, and data, providing a uniform and professional look to your API.

- **Error Handling**: Efficiently manage error responses with detailed error messages, appropriate status codes, and response formatting that complies with best practices.

- **Customization**: Tailor the response format to suit your project's specific needs, offering flexibility to meet various API requirements.

- **Laravel Integration**: Seamlessly integrates with Laravel, enhancing Laravel's response system with additional features.

- **Time Efficiency**: Reduce the development effort required for consistent API responses, allowing you to focus on your application's core functionality rather than response formatting.

The `ymigval/laravel-sl-response` package empowers you to build and maintain professional, reliable APIs that meet industry standards. Whether you're developing a new API or improving an existing one, this package is an invaluable addition to your Laravel toolkit.


## Installation

You can install the package via Composer:

```bash
composer require ymigval/laravel-sl-response
```

You can publish the configuration file using the following command:

```bash
php artisan vendor:publish --tag="slresponse"
```

## Usage

Response from a route or controller method.

```php
use Ymigval\LaravelSLResponse\Facades\SLResponse;
use Ymigval\LaravelSLResponse\Exceptions\SLException;

// Collection of users
return SLResponse::ok(User::all());

// A User resource
return SLResponse::ok(new UserResource(User::find(1)));

// If you want to disable the outermost wrapping.
return SLResponse::ok(UserResource::collection(User::paginate(10)))
        ->withoutWrapping();

// Attach additional messages.
return SLResponse::ok(User::find(6)->isAdmin())
        ->withMessage("This user is an admin");

// Return an error response.
return SLResponse::error('Limit exceeded');

// Throw an exception
throw new SLException('This is a message.');
```

## Changelog
Please refer to the [CHANGELOG](CHANGELOG.md) for more information about recent changes.



## License
The MIT License (MIT). For more information, please see the [License File](LICENSE).