# Fingerprint

A Laravel package for fingerprint capture, storage, and matching.

## Features

- Capture fingerprints using various scanners
- Store fingerprint templates in multiple formats
- Match fingerprints against stored records
- Debug mode for troubleshooting
- Support for different fingerprint matching algorithms

## Installation

You can install the package via composer:

```bash
composer require sq/fingerprint
```

Then publish the configuration file:

```bash
php artisan vendor:publish --provider="Sq\Fingerprint\FingerprintServiceProvider" --tag="fingerprint-config"
```

## Configuration

After publishing the configuration, you can find it at `config/fingerprint.php`. The main configuration options include:

- `storage_path` - Where to store fingerprint templates
- `threshold` - Matching threshold score (0-100)
- `algorithm` - Parameters for the matching algorithm
- `match_binary` - Path to external matching binary (if used)
- `debug` - Enable detailed logging

## Basic Usage

### Storing a Fingerprint

```php
use Sq\Fingerprint\Facades\Fingerprint;

// Store a fingerprint with an identifier
$result = Fingerprint::store([
    'ISOTemplateBase64' => $isoTemplate,
    'TemplateBase64' => $proprietaryTemplate,
    'BMPBase64' => $imageData
], 'user-123');
```

### Matching a Fingerprint

```php
use Sq\Fingerprint\Facades\Fingerprint;

// Match against all stored fingerprints
$result = Fingerprint::match([
    'ISOTemplateBase64' => $isoTemplate,
    'TemplateBase64' => $proprietaryTemplate,
    'BMPBase64' => $imageData
]);

if ($result['matched']) {
    $identifierFound = $result['identifier'];
    $matchScore = $result['score'];
    $matchMethod = $result['method'];
}
```

### Verifying Against a Specific Identifier

```php
use Sq\Fingerprint\Facades\Fingerprint;

// Match against a specific identifier
$result = Fingerprint::match([
    'ISOTemplateBase64' => $isoTemplate
], ['user-123']);

$isVerified = $result['matched'];
```

## Routes

The package includes the following routes:

- `GET /fingerprint/identification` - Displays the fingerprint identification UI
- `POST /fingerprint/match` - API endpoint for matching fingerprints
- `POST /fingerprint/template/store` - Stores a fingerprint template
- `POST /fingerprint/template/verify` - Verifies a fingerprint against a specific identifier
- `DELETE /fingerprint/template/delete` - Deletes a stored fingerprint

## Troubleshooting

If you encounter issues with fingerprint matching:

1. Enable debug mode in the configuration
2. Check storage permissions for the fingerprint templates directory
3. Use the debug output in the matching response to identify issues
4. Verify scanner compatibility with your system

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. 
