## Preparando ambiente com PHP

Este projeto utiliza versão latest do PHP com [xdebug](https://xdebug.org/) utilizando [Docker](https://docs.docker.com/engine/reference/builder/) e [docker-compose](https://docs.docker.com/compose/).

Para levantar o ambiente com PHP clone o projeto e levante o ambiente com docker:

```bash
docker-compose up
```

> **PS**: Gosto de utilizar `docker-compose up` e não `docker-compose up -d` para que possamos monitorar logs dos containers mais facilmente.