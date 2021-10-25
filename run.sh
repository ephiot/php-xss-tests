#!/bin/bash
docker build -t php-xss-test .
docker run -it --rm --name running-php-xss-test --mount type=bind,source="$(pwd)",target=/app php-xss-test
