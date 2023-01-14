FROM mariadb:latest

# Set an insecure password
#ENV MYSQL_ROOT_PASSWORD=example

# Copy over our SQL queries
COPY ./data/init.sql /init.sql

# Startup MySQL and run the queries
CMD ["mysqld", "--init-file=/init.sql"]