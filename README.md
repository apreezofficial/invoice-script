# Invoice Management API

## Overview
This is a RESTful API built with Laravel 12, designed for user authentication and invoice management. It utilizes Laravel Sanctum for secure, token-based authentication and Eloquent ORM for database interactions.

## API Documentation
### Base URL
The base URL for all API endpoints is `http://localhost:8000`.

### Endpoints
#### POST /register
Registers a new user and returns a user object with an API token.

**Request**:
```json
{
  "name": "John Doe",
  "email": "john.doe@example.com",
  "password": "password123"
}
```

**Response**:
```json
{
    "status": "success",
    "message": "User registered successfully",
    "data": {
        "user": {
            "name": "John Doe",
            "email": "john.doe@example.com",
            "updated_at": "2024-05-21T10:00:00.000000Z",
            "created_at": "2024-05-21T10:00:00.000000Z",
            "id": 1
        },
        "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
    }
}
```

**Errors**:
- `422 Unprocessable Entity`: Validation failed (e.g., email already taken, password too short).

#### POST /login
Authenticates a user and returns a user object with a new API token.

**Request**:
```json
{
  "email": "john.doe@example.com",
  "password": "password123"
}
```

**Response**:
```json
{
    "status": "success",
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john.doe@example.com",
            "email_verified_at": null,
            "created_at": "2024-05-21T10:00:00.000000Z",
            "updated_at": "2024-05-21T10:00:00.000000Z"
        },
        "token": "2|yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy"
    }
}
```

**Errors**:
- `401 Unauthorized`: Invalid credentials.
- `422 Unprocessable Entity`: Validation failed.

#### GET /user
Retrieves the details of the authenticated user. Requires `Authorization: Bearer <token>`.

**Request**:
*No payload required.*

**Response**:
```json
{
    "id": 1,
    "name": "John Doe",
    "email": "john.doe@example.com",
    "email_verified_at": null,
    "created_at": "2024-05-21T10:00:00.000000Z",
    "updated_at": "2024-05-21T10:00:00.000000Z"
}
```

**Errors**:
- `401 Unauthorized`: Authentication token is missing or invalid.

#### GET /invoices
Retrieves a list of all invoices for the authenticated user. Requires `Authorization: Bearer <token>`.

**Request**:
*No payload required.*

**Response**:
```json
{
    "status": "success",
    "message": "Invoices retrieved successfully",
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "invoice_number": "INV-2024-001",
            "status": "paid",
            "due_date": "2024-06-01",
            "description": "Web Development Services",
            "created_at": "2024-05-21T10:05:00.000000Z",
            "updated_at": "2024-05-21T10:05:00.000000Z"
        }
    ]
}
```

**Errors**:
- `401 Unauthorized`: Authentication token is missing or invalid.

#### POST /invoices
Creates a new invoice for the authenticated user. Requires `Authorization: Bearer <token>`.

**Request**:
```json
{
  "invoice_number": "INV-2024-002",
  "status": "pending",
  "due_date": "2024-06-15",
  "description": "Graphic Design Work"
}
```

**Response**:
```json
{
    "status": "success",
    "message": "Invoice created successfully",
    "data": {
        "user_id": 1,
        "invoice_number": "INV-2024-002",
        "status": "pending",
        "due_date": "2024-06-15",
        "description": "Graphic Design Work",
        "updated_at": "2024-05-21T10:10:00.000000Z",
        "created_at": "2024-05-21T10:10:00.000000Z",
        "id": 2
    }
}
```

**Errors**:
- `401 Unauthorized`: Authentication token is missing or invalid.
- `422 Unprocessable Entity`: Validation failed (e.g., missing fields, invalid status).

#### GET /invoices/{id}
Retrieves a single invoice by its ID. Requires `Authorization: Bearer <token>`.

**Request**:
*No payload required.*

**Response**:
```json
{
    "status": "success",
    "message": "Invoice retrieved successfully",
    "data": {
        "id": 1,
        "user_id": 1,
        "invoice_number": "INV-2024-001",
        "status": "paid",
        "due_date": "2024-06-01",
        "description": "Web Development Services",
        "created_at": "2024-05-21T10:05:00.000000Z",
        "updated_at": "2024-05-21T10:05:00.000000Z"
    }
}
```

**Errors**:
- `401 Unauthorized`: Authentication token is missing or invalid.
- `404 Not Found`: Invoice not found or does not belong to the user.

#### PUT /invoices/{id}
Updates an existing invoice by its ID. Requires `Authorization: Bearer <token>`.

**Request**:
```json
{
  "invoice_number": "INV-2024-001-UPDATED",
  "status": "paid",
  "due_date": "2024-06-01",
  "description": "Updated Web Development Services"
}
```

**Response**:
```json
{
    "status": "success",
    "message": "Invoice updated successfully",
    "data": {
        "id": 1,
        "user_id": 1,
        "invoice_number": "INV-2024-001-UPDATED",
        "status": "paid",
        "due_date": "2024-06-01",
        "description": "Updated Web Development Services",
        "created_at": "2024-05-21T10:05:00.000000Z",
        "updated_at": "2024-05-21T10:15:00.000000Z"
    }
}
```

**Errors**:
- `401 Unauthorized`: Authentication token is missing or invalid.
- `404 Not Found`: Invoice not found or does not belong to the user.
- `422 Unprocessable Entity`: Validation failed.

#### DELETE /invoices/{id}
Deletes an invoice by its ID. Requires `Authorization: Bearer <token>`.

**Request**:
*No payload required.*

**Response**:
```json
{
    "status": "success",
    "message": "Invoice deleted successfully",
    "data": null
}
```

**Errors**:
- `401 Unauthorized`: Authentication token is missing or invalid.
- `404 Not Found`: Invoice not found or does not belong to the user.