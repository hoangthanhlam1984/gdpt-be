# API Documentation

## Auth Module

### Login

- **Endpoint:** `POST /v1/auth/login`
- **Description:** Authenticates a user and returns an API token.
- **Request Body:**
  ```json
  {
    "email": "user@example.com",
    "password": "password"
  }
  ```
- **Validation Rules:**
  - `email`: required, must be a valid email address.
  - `password`: required.
- **Success Response (200 OK):**
  ```json
  {
    "access_token": "your-auth-token",
    "token_type": "Bearer"
  }
  ```
- **Error Response (422 Unprocessable Entity):**
  - If validation fails or credentials are incorrect.

### Get Authenticated User

- **Endpoint:** `GET /v1/me`
- **Description:** Retrieves the details of the currently authenticated user.
- **Authentication:** Bearer Token required.
- **Success Response (200 OK):**
  ```json
  {
    "id": 1,
    "name": "Test User",
    "email": "user@example.com"
  }
  ```
- **Error Response (401 Unauthorized):**
  - If no valid token is provided.

### Update Profile

- **Endpoint:** `PUT /v1/me`
- **Description:** Updates the profile of the currently authenticated user.
- **Authentication:** Bearer Token required.
- **Request Body:**
  ```json
  {
    "name": "New Name",
    "password": "new-password",
    "password_confirmation": "new-password"
  }
  ```
- **Validation Rules:**
  - `name`: optional, string, max 255 characters.
  - `password`: optional, string, min 8 characters, must be confirmed.
- **Success Response (200 OK):**
  ```json
  {
    "id": 1,
    "name": "New Name",
    "email": "user@example.com"
  }
  ```
- **Error Responses:**
  - `401 Unauthorized`: If no valid token is provided.
  - `422 Unprocessable Entity`: If validation fails.

---

## User Module

All endpoints in this module require Bearer Token authentication.

### List & Search Users

- **Endpoint:** `GET /v1/users`
- **Description:** Retrieves a paginated list of users. Can be filtered by query parameters.
- **Query Parameters:**
  - `name` (string): Filter by user name (partial match).
  - `email` (string): Filter by user email (partial match).
  - `is_active` (boolean): Filter by user status.
  - `page` (integer): The page number to retrieve.
  - `per_page` (integer): The number of items per page.
- **Success Response (200 OK):**
  ```json
  {
    "data": [
      {
        "id": 1,
        "name": "Test User 1",
        "email": "user1@example.com"
      },
      {
        "id": 2,
        "name": "Test User 2",
        "email": "user2@example.com"
      }
    ],
    "meta": {
      "current_page": 1,
      "from": 1,
      "last_page": 1,
      "per_page": 15,
      "to": 2,
      "total": 2
    }
  }
  ```

### Create User

- **Endpoint:** `POST /v1/users`
- **Description:** Creates a new user.
- **Request Body:**
  ```json
  {
    "name": "New User",
    "email": "newuser@example.com",
    "password": "password"
  }
  ```
- **Validation Rules:**
  - `name`: required, string, max 255 characters.
  - `email`: required, email, max 255 characters, must be unique in the `users` table.
  - `password`: required, string, min 6 characters.
- **Success Response (201 Created):**
  ```json
  {
    "id": 3,
    "name": "New User",
    "email": "newuser@example.com"
  }
  ```

### Get User Details

- **Endpoint:** `GET /v1/users/{userId}`
- **Description:** Retrieves the details of a specific user.
- **Path Parameters:**
  - `userId` (integer): The ID of the user.
- **Success Response (200 OK):**
  ```json
  {
    "id": 1,
    "name": "Test User",
    "email": "user@example.com"
  }
  ```
- **Error Response (404 Not Found):**
  - If the user with the specified ID does not exist.

### Update User

- **Endpoint:** `PUT /v1/users/{userId}`
- **Description:** Updates an existing user.
- **Path Parameters:**
  - `userId` (integer): The ID of the user to update.
- **Request Body:**
  ```json
  {
    "name": "Updated Name",
    "email": "updated@example.com",
    "password": "new-password",
    "is_active": true
  }
  ```
- **Validation Rules:**
  - `name`: optional, string, max 255 characters.
  - `email`: optional, email, max 255 characters, must be unique (ignoring the current user).
  - `password`: optional, string, min 6 characters.
  - `is_active`: optional, boolean.
- **Success Response (204 No Content):**
  - An empty body is returned on successful update.
- **Error Response (404 Not Found):**
  - If the user with the specified ID does not exist.

### Delete User

- **Endpoint:** `DELETE /v1/users/{userId}`
- **Description:** Deletes a user.
- **Path Parameters:**
  - `userId` (integer): The ID of the user to delete.
- **Success Response (204 No Content):**
  - An empty body is returned on successful deletion.
- **Error Response (404 Not Found):**
  - If the user with the specified ID does not exist.
