# Sayit

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ekandreas/sayit.svg?style=flat-square)](https://packagist.org/packages/ekandreas/sayit)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/ekandreas/sayit/run-tests?label=tests)](https://github.com/ekandreas/sayit/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/ekandreas/sayit/Check%20&%20fix%20styling?label=code%20style)](https://github.com/ekandreas/sayit/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/ekandreas/sayit.svg?style=flat-square)](https://packagist.org/packages/ekandreas/sayit)

---
Converts text to speech via AWS and place it in a S3 bucket folder
This package is PHP agnostic. Follow these steps to get started:

1. `composer require ekandreas/sayit`
2. Register an IAM programmatic account and set policy S3 full access and Polly Full Access to it.
3. Use the key, secret, region and bucket name with the factory helper.
4. Open a public folder in your S3 bucket and create a folder in it.
---

Code example:
```php
$factory = TextToSpeech::make(
    $aws_key,
    $aws_secret,
    $aws_region,
    $aws_bucket
)
    ->voice("Astrid")
    ->generate("Hej på dig, det här kommer att läsas upp i en mp3 efter generering.")
    ->store("your-folder");

// the url now points to a public s3 folder "your-folder" with a unique mp3 file generated from the text above.
$url = $factory->url();
```

## Installation

You can install the package via composer:

```bash
composer require ekandreas/sayit
```

## Testing

```bash
composer test
```

## Credits

- [Andreas Ek](https://github.com/ekandreas)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
