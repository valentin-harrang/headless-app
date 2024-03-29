headless-app
==============

This is an headless app that uses API Platform with Symfony 5 (latest version), Postgres and PHP8 for the backend and Next.js for the frontend.

# Prerequisites

- Docker with Docker Compose
- Npm

# Project installation

First, clone this repository:

```bash
$ git clone https://github.com/valentin-harrang/headless-app
```

Next, add `headless-app.test` in your `/etc/hosts` file.

Go to `back` directory:

```bash
$ cd back
```

- See [Backend](back/README.md)
- Finally, see [Frontend](front/README.md)

## Hosting

- Frontend is hosted on Vercel at this URL: https://headless-app-4mirtdbnr-valentin-harrang.vercel.app/
- Backend is hosted on a VPS using Traefik and Docker at this URL: https://dev.valentin-harrang.fr/
