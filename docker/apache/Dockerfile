# Use the lightweight alpine Apache image
FROM httpd:alpine

# Update Alpine's package manager, apk
RUN apk update; \
    apk upgrade

# Copy config files into the container
COPY apache.conf /usr/local/apache2/conf/apache.conf

# Add a reference to the config file into to the default Apache config
RUN echo "Include /usr/local/apache2/conf/apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf