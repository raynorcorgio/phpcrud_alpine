FROM mysql:8

COPY ./docker/mysql/mysql-config.cnf /etc/mysql/conf.d/config.cnf
COPY ./docker/mysql/000-init.sql /docker-entrypoint-initdb.d/
