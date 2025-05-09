# Fingerprint

A Laravel package for fingerprint capture, storage, and matching.

## Features

- Capture fingerprints using various scanners
- Store fingerprint templates in multiple formats
- Match fingerprints against stored records
- Verify fingerprints against each other or against stored templates
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

### Card Info Biometric Routes

- `GET /fingerprint/cardinfo` - Displays the card biometric identification UI
- `POST /fingerprint/cardinfo/match` - Matches a fingerprint against stored card records
- `GET /fingerprint/cardinfo/all` - Returns all card info records with biometric data
- `GET /fingerprint/cardinfo/{id}` - Returns a specific card info record with biometric data
- `GET /fingerprint/cardinfo/verify/{cardInfoId?}` - Fingerprint verification page, optionally with a specific card ID
- `POST /fingerprint/cardinfo/verify` - API endpoint for verifying a fingerprint against a card's stored template

## Fingerprint Verification

The package includes a fingerprint verification page that allows users to verify fingerprints in two ways:

### Using the Verify Page

Access the verification page at `/fingerprint/cardinfo/verify` or `/fingerprint/cardinfo/verify/{cardInfoId}` to:

1. **Scan two fingerprints for direct comparison**:
   - Click "Scan First" to capture the first fingerprint
   - Click "Scan Second" to capture the second fingerprint
   - Set a matching threshold score (default is 100)
   - Click "Verify" to compare the fingerprints

2. **Load a stored fingerprint and verify against a new scan**:
   - Enter a Card ID and click "Load Stored" or navigate directly to `/fingerprint/cardinfo/verify/{cardInfoId}`
   - The stored fingerprint will be loaded automatically
   - Click "Scan Second" to capture a fingerprint for comparison
   - Click "Verify" to compare against the stored template

### Client-Side Verification

The verification uses SecuGen WebAPI for client-side fingerprint matching:

- The fingerprint scanner should be connected to the client machine
- SecuGen WebAPI service must be running at `https://localhost:8443`
- Matching is performed directly in the browser for maximum privacy and performance
- Results are displayed immediately with a matching score

### API-Based Verification

For server-side verification, the API endpoint is available at:

```
POST /fingerprint/cardinfo/verify
```

With the following JSON payload:
```json
{
  "cardInfoId": 123,
  "scannedTemplate": "base64-encoded-template",
  "matchThreshold": 100
}
```

The response will include success status, match result, and matching score.

## Troubleshooting

If you encounter issues with fingerprint matching:

1. Enable debug mode in the configuration
2. Check storage permissions for the fingerprint templates directory
3. Use the debug output in the matching response to identify issues
4. Verify scanner compatibility with your system
5. Ensure SecuGen WebAPI is properly installed and running on the client machine

### SecuGen WebAPI Setup

The fingerprint verification feature requires SecuGen WebAPI:

1. Download the appropriate installer from the vendor:
   - Win64b WebAPI: `SGI_BWAPI_WIN_64bit.exe`
   - Win32b WebAPI: `SGI_BWAPI_WIN_32bit.exe`
2. Install and ensure the service is running
3. Test connectivity by accessing `https://localhost:8443` in the browser

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. 
