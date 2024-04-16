# Partir de l'image officielle de PostgreSQL comme base
# https://hub.docker.com/_/postgres
FROM postgres:16
#-alpine

# Récupérer les args du build et les transmettres au conteneur
# Ils seront nécessaire à l'initialisation de la base de données.
# ARG plutôt que ENV : définies le temps du build
ARG POSTGRES_PHP_USER=${POSTGRES_PHP_USER}
ENV POSTGRES_PHP_USER=${POSTGRES_PHP_USER}

ARG POSTGRES_PHP_PASSWORD=${POSTGRES_PHP_PASSWORD}
ENV POSTGRES_PHP_PASSWORD=${POSTGRES_PHP_PASSWORD}

ARG POSTGRES_SCRIPTS_INIT_DIR=${POSTGRES_SCRIPTS_INIT_DIR}

RUN echo "POSTGRES_PHP_USER=$POSTGRES_PHP_USER"

COPY ${POSTGRES_SCRIPTS_INIT_DIR} /docker-entrypoint-initdb.d/
