# API Documentation

## Auth

### POST /api/v1/auth/login

Request Body (JSON)
```
{
  "email": "user@example.com",
  "password": "secret"
}
```

Response 200
```
{
  "access_token": "<token>",
  "token_type": "Bearer",
  "expires_in": 3600
}
```

Errors
- 422 Invalid credentials
