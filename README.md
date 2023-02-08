# Revoke Token Service
A micro-service API for revoking tokens

## API

## Revoke Token
 - `GET /api/revoke/{token}` or `GET /api/revoke/{identifier}/{token}`
    - `token` is the token to be revoked
    - `identifier` is the identifier of the token to be revoked

 - if the token is revoked, the response will be `200`
    ```json
    {
        "revoked": true
    }
    ```

## Validate token
 - `GET /api/validate/{token}` or `GET /api/validate/{identifier}/{token}`
    - `token` is the token to be validated
    - `identifier` is the identifier of the token to be validated

 - if the token is revoked, the response will be `200`

    ```json
    {
        "revoked": true
    }
    ```