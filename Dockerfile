FROM php:7.4-cli
WORKDIR /app
COPY . .
CMD [ "php", "./test.php" ]