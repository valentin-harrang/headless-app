headless-app
==============

This is an headless app that uses API Platform with Symfony 5 (latest version) and PHP8 for the backend and Nuxt 3 for the frontend.

# Installation

First, clone this repository:

```bash
$ git clone https://github.com/valentin-harrang/headless-app
```

Next, add `headless-app.test` in your `/etc/hosts` file.

Make sure you adjust `DATABASE_URL` in `env` to the database container alias "db".

Go to back directory:

```bash
$ cd back
```

Then, run:

```bash
$ docker-compose up
```

You need to run `sudo chown -R 5050:5050 ./docker/pgadmin` If you get this following message:

> pgadmin    | WARNING: Failed to set ACL on the directory containing the configuration database:
> pgadmin    |            [Errno 1] Operation not permitted: '/var/lib/pgadmin'
> pgadmin    | HINT   : You may need to manually set the permissions on
> pgadmin    |          /var/lib/pgadmin to allow pgadmin to write to it.

You are done, you can visit your Symfony application on the following URL: `http://headless-app.test`.

_Note :_ you can rebuild all Docker images by running:

```bash
$ docker-compose build
```

# How it works?

Here are the `docker-compose` built images:

* `db`: This is the Postgres database container (can be changed to postgresql or whatever in `docker-compose.yml` file),
* `php`: This is the PHP-FPM container including the application volume mounted on,
* `nginx`: This is the Nginx webserver container in which php volumes are mounted too,

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

# Environment Customizations

You can customize the exposed ports and other parameters changing the docker-compose .env file.

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
