headless-app - back
==============

# Installation

- Run: `docker-compose up`


- If you get a permissions problem with `pgadmin` container You need to run `sudo chown -R 5050:5050 ./.docker/pgadmin` 


- Go into the container: `docker exec -it php-fpm`


- Install dependencies: `composer install`


- Create `jwt` directory: `mkdir config/jwt`


- Generate private key: `openssl genrsa -out config/jwt/private.pem -aes256 4096`


- Generate public key: `openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem`


- Set permissions: `chmod 644 config/jwt/public.pem config/jwt/private.pem`


- Replace `JWT_PASSPHRASE` value by your jwt passphrase in `.env` file


- Execute migrations: `php bin/console doctrine:migrations:migrate`


- Execute fixtures: `php bin/console doctrine:fixtures:load`


- Import news feed: `php bin/console import-news`


You are done, you can visit your Symfony application on the following URL: `http://headless-app.test`.

_Note :_ you can rebuild all Docker images by running:

```bash
$ docker-compose build
```

# How it works?

Here are the `docker-compose` built images:

* `db`: This is the Postgres database container (can be changed to mysql or whatever in `docker-compose.yml` file),
* `php`: This is the PHP-FPM container including the application volume mounted on,
* `nginx`: This is the Nginx webserver container in which php volumes are mounted too,
* `pgadmin`: This is the Pgadmin container to manage database,

This results in the following running containers:

```bash
> $ docker-compose ps
   Name                 Command               State                 Ports
---------------------------------------------------------------------------------------
db        docker-entrypoint.sh postgres   Up      0.0.0.0:3306->5432/tcp
nginx     /docker-entrypoint.sh nginx     Up      443/tcp, 0.0.0.0:80->80/tcp
pgadmin   /entrypoint.sh                  Up      443/tcp, 0.0.0.0:5050->80/tcp
php-fpm   php-fpm8 -F                     Up      0.0.0.0:9000->9001/tcp
```

# Authenticate to the API

Make a POST request to the login route: `http://headless-app.test/api/login` with this body parameters:
```json
{
    "username": "contact@valentin-harrang.fr",
    "password": "123456!"
}
```

In response, you will get a `bearer token` like this:
```json
{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2Mzk5MTAxMTIsImV4cCI6MTYzOTkxMzcxMiwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiY29udGFjdEB2YWxlbnRpbi1oYXJyYW5nLmZyIn0.fId2bV7bajQMCIn37UQanCNmQ-xeohzR8IqeiB0gvHku1PlVvcFePxnCYNFo90bLzj56SPmTInW4LROuwsATF29DXQmMfJ9aJm5O-fsGU4hLGyLQU8LZjeA3tMypulbcBOan2JczrNWIOkwiDGSiJArp8-XHkk5xAmMYbT82gwmb5oHFTnyQjogev42oGOROWyqz0O4ZE_Dhlmmg2tWJrZoQbDNC6kge11tjrvXZ6Dp_IcYx4YfZMelIVOEm4NfHTBK1u7L1D-yAJlFFQ2cZ30R3AVGiOO5eLRY1RU8f0kVlHoGsVVG69WUEXxwudO-McsWPRTLRioGFtzJ8ZWzqVP6qyeJYJRzovNZiniWIuh7akYV34bcDpqBLlGvtSojHMFHnkYzWU_J2tU7ymg2ybrLlMXK5ma7HlLD4SPXbVZU9uRf9Vph114fw2Cgz-AaETUIAcLvcLiueFKTDzkUhf90WojPRh9MB2VKmEPT1iWWCjFwwUcgrAFq8zngFxt1HhK2Qmpq0M0EAi0nUbN8MMujEDFEtoagu-XoLwz-sQm9ZTXnKMK_g1ri8lGH70vnRciynahX65jQFNLSE-Ng_vG-K_mPZgpd-n81_cx6T_N1jFSWQqdqSnUTyHgW_U9HZ34PYWNVfVERgWQhsXx9Yms-I7_DuEEMXtXxMkQrF-vI"}
```

Use this token to make your requests such as getting news.
For example you can make a GET request on `http://headless-app.test/api/news` like this:
```
curl --location --request GET 'http://headless-app.test/api/news' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2Mzk5MTAxMTIsImV4cCI6MTYzOTkxMzcxMiwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiY29udGFjdEB2YWxlbnRpbi1oYXJyYW5nLmZyIn0.fId2bV7bajQMCIn37UQanCNmQ-xeohzR8IqeiB0gvHku1PlVvcFePxnCYNFo90bLzj56SPmTInW4LROuwsATF29DXQmMfJ9aJm5O-fsGU4hLGyLQU8LZjeA3tMypulbcBOan2JczrNWIOkwiDGSiJArp8-XHkk5xAmMYbT82gwmb5oHFTnyQjogev42oGOROWyqz0O4ZE_Dhlmmg2tWJrZoQbDNC6kge11tjrvXZ6Dp_IcYx4YfZMelIVOEm4NfHTBK1u7L1D-yAJlFFQ2cZ30R3AVGiOO5eLRY1RU8f0kVlHoGsVVG69WUEXxwudO-McsWPRTLRioGFtzJ8ZWzqVP6qyeJYJRzovNZiniWIuh7akYV34bcDpqBLlGvtSojHMFHnkYzWU_J2tU7ymg2ybrLlMXK5ma7HlLD4SPXbVZU9uRf9Vph114fw2Cgz-AaETUIAcLvcLiueFKTDzkUhf90WojPRh9MB2VKmEPT1iWWCjFwwUcgrAFq8zngFxt1HhK2Qmpq0M0EAi0nUbN8MMujEDFEtoagu-XoLwz-sQm9ZTXnKMK_g1ri8lGH70vnRciynahX65jQFNLSE-Ng_vG-K_mPZgpd-n81_cx6T_N1jFSWQqdqSnUTyHgW_U9HZ34PYWNVfVERgWQhsXx9Yms-I7_DuEEMXtXxMkQrF-vI'
```

# Environment Customizations

You can customize the exposed ports and other parameters changing the docker-compose `.env` file.

# Read logs

You can access Nginx and Symfony application logs in the following directories on your host machine:

* `back/.docker/logs/nginx`
* `back/.docker/logs/symfony`

# Use xdebug!

Start by updating your docker-compose .env file with `PHP_XDEBUG_MODE=debug` (or any other configuration you need as seen in the [Xdebug documentation](https://xdebug.org/docs/all_settings#mode)).
You will need to re-build the php container for this value to take effect.

Configure your IDE to use port 5902 for XDebug.
Docker versions below 18.03.1 don't support the Docker variable `host.docker.internal`.  
In that case you'd have to swap out `host.docker.internal` with your machine IP address in php-fpm/xdebug.ini.

## Possible improvements

- Add possibility to choose feed category via API and Symfony command (for example: "Tennis" in l'Equipe feed)
- Add possibility to choose feed via API and Symfony command (for example: Le Monde instead of l'Equipe)
- When there is a Symfony error, Nginx throws a 502 error (bad gateway)

## Blocking points

I didn't encounter any major difficulties but spent a lot of time trying to fix Nginx error 502 without success.