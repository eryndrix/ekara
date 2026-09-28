#!/bin/bash
set -e

# Create certs directory
mkdir -p /var/lib/postgresql/certs

# Copy certs (running as root, host files are readable)
cp /tmp/certs/postgres.crt /var/lib/postgresql/certs/postgres.crt
cp /tmp/certs/postgres.key /var/lib/postgresql/certs/postgres.key
cp /tmp/certs/ca.crt /var/lib/postgresql/certs/ca.crt

# Set ownership and permissions for certs
chown -R postgres:postgres /var/lib/postgresql/certs
chmod 700 /var/lib/postgresql/certs
chmod 600 /var/lib/postgresql/certs/postgres.key

# Ensure log directory exists and is owned by postgres
mkdir -p /var/log/postgresql
chown -R postgres:postgres /var/log/postgresql
chmod 755 /var/log/postgresql

# Start PostgreSQL as the postgres user
exec su postgres -c "docker-entrypoint.sh postgres -c config_file=/etc/postgresql/postgresql.conf"
