# VINDecoder

VIN (Vehicle Identification Number) decoder using [Vincario API](https://vindecoder.eu)

## Setup:

```
composer require errorname/vin-decoder dev-master
```

Then, add the Service Provider in your file config/app.php

```
Errorname\VINDecoder\VINDecoderServiceProvider::class
```

## Usage:

```php

use Errorname\VINDecoder\Decoder;

//

Decoder::info('XXXDEF1GH23456789'); // Retrieve the list of available information about this VIN

//

$vin = Decoder::decode('XXXDEF1GH23456789'); // Retrieve the actual information about this VIN

echo $vin->Make;
echo $vin['Plant Country'];

echo isset($vin['Number of Seats']) ? 'Seats: '.$vin['Number of Seats'] : 'No seats';

print_r($vin->available()); // Print the list of available information about this VIN

//

$balance = Decoder::balance();

echo "API requests left: ".$balance;

```

## License

VINDecoder is an open-sourced software licensed under the [MIT License](http://opensource.org/licenses/MIT).
