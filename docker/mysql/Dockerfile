FROM mysql:8

COPY ./mysql-config.cnf /etc/mysql/conf.d/config.cnf
COPY ./000-init.sql /docker-entrypoint-initdb.d/
