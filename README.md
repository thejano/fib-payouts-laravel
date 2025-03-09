# Fib Payouts Laravel Package

## Introduction
`thejano/fib-payouts-laravel` is a Laravel package that provides an easy way to interact with the **FIB Payout API** using OAuth2 authentication. It supports:

- Retrieving an **OAuth2 access token**
- **Creating payouts**
- **Authorizing payouts**
- **Fetching payout details**

This package supports **Laravel 9 and above** and simplifies integration with the FIB API.

---

## Requests
All requests need to be authenticated with an **Access Token** acquired via the **OAuth2 Client Credentials Grant Flow** using the `client_id` and `client_secret` provided by FIB.

### API Flow
- **Authentication**: Authenticates the user and provided credentials, returning a token for future requests.
- **Payout Creation**: Creates a payout transaction.
- **Payout Authorization**: Authorizes a payout after its creation, ensuring validation before processing. This step secures the transaction before transferring funds to the recipient's account.
- **Getting Payout Details**: Retrieves all relevant details of a payout transaction.

---

## Installation
### 1. Install the Package
Run the following command:
```sh
composer require thejano/fib-payouts-laravel
```

### 2. Publish the Configuration File
```sh
php artisan vendor:publish --provider="TheJano\FibPayouts\FibPayoutServiceProvider"

```
This will create the config file `config/fib-payout.php`.

### 3. Configure Environment Variables
Add the following to your `.env` file:
```env
FIB_PAYOUT_ENV=staging # Change to 'production' for live API
FIB_PAYOUT_CLIENT_ID=your_client_id
FIB_PAYOUT_CLIENT_SECRET=your_client_secret
```

### 4. Clear Config Cache
Run:
```sh
php artisan config:clear
```

---

## Usage
This package provides a **Facade** for easy usage:
```php
use TheJano\FibPayouts\Facades\FibPayout;
```

### 1. Get OAuth2 Token
This function retrieves an OAuth2 access token, which is required for making API requests.

```php
$token = FibPayout::getToken();
```
#### **Response:**
```json
"your_access_token"
```

### 2. Create a Payout
This function initiates a payout transaction by providing the necessary details.

```php
$payout = FibPayout::createPayout([
    'amount' => ['amount' => 1000, 'currency' => 'IQD'],
    'targetAccountIban' => 'IQ23FIQB004085190510001',
    'description' => 'Payment for services'
]);
```
#### **Response:**
```json
{
    "payoutId": "12345-abcde-67890"
}
```

### 3. Authorize a Payout
After creating a payout, it must be authorized to complete the transaction.

```php
$response = FibPayout::authorizePayout('12345-abcde-67890');
```
#### **Response:**
If the payout is successfully authorized, the response will be empty. If there is an error, it will return an error.

### 4. Get Payout Details
This function retrieves details of a specific payout transaction.

```php
$details = FibPayout::getPayoutDetails('12345-abcde-67890');
```
#### **Expected Response:**
```json
{
    "payoutId": "12345-abcde-67890",
    "status": "AUTHORIZED",
    "targetAccountIban": "IQ23FIQB004085190510001",
    "description": "Payment for services",
    "amount": {
        "amount": 1000,
        "currency": "IQD"
    },
    "authorizedAt": "2025-03-09T08:45:52.516174Z",
    "failedAt": null
}
```

#### **Response Fields:**
- `payoutId`: The unique identifier of the payout.
- `status`: The current status of the payout, which can be one of the following: `CREATED`, `AUTHORIZED`, `FAILED`.
- `targetAccountIban`: The IBAN of the recipient's account.
- `description`: A string describing the transaction.
- `amount`: The payout amount to be transferred.
- `authorizedAt`: An integer representing the time of the transaction authorization (e.g., `1720599438`). This field can be `null` if the transaction wasn't authorized.
- `failedAt`: An integer representing the time of the transaction failure (e.g., `1720599438`). This field can be `null` if the transaction was successful.


---

## Running Tests
### Run Pest Tests
```sh
./vendor/bin/pest
```
If using Laravel:
```sh
php artisan test
```

---

## License
This package is released under the **MIT License**.

---

## Support
If you encounter any issues, feel free to open an issue on GitHub or contact `TheJano`. 

