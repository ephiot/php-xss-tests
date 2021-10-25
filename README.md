# php-xss-tests
Test a method against a list of XSS known.

# How to run
Just execute "run.sh", it will start a docker container to do all stuff.

# How I know if my code was successfull ?
After run the container the dirs/files below will be created:

- html/
  - xss/      <- HTML with XSS
    - *.html
  - no-xss/   <- HTML with cleanned XSS
    - *.html
- xss-report.csv

You should open the HTML to see if XSS is working, if not your code was successfull.

# About the XSS list
All the XSS in "xss-fixture.txt" was obtained from https://portswigger.net/web-security/cross-site-scripting/cheat-sheet

# Known issues
The "html" dir is creted from the container and is owned by "root" user.
