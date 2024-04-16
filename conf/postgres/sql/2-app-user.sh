#!/bin/bash
set -e

# Commandes SQL de création d'utilisateur applicatif
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    -- Créer l'utilisateur dédiée à l'application PHP
    CREATE USER $POSTGRES_PHP_USER WITH PASSWORD '$POSTGRES_PHP_PASSWORD';

    -- Lui donner accès en lecture (SELECT) à toutes les tables de la BDD (POSTGRES_DB)
    GRANT SELECT ON ALL TABLES IN SCHEMA public TO $POSTGRES_PHP_USER;
EOSQL
