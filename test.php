<?php

require_once './helpers.php';
require_once './XSSClean.php';

const HTML_XSS_DIR = './html/xss/';
const HTML_NOXSS_DIR = './html/no-xss/';

echo "Loading XSS fixture file...\n";

$fixture = new SplFileObject('xss-fixture.txt');

echo "Openning CSV report file...\n";

$report = new SplFileObject("xss-report.csv", 'w+');
writeCSVLine($report, 'Id', 'XSS', 'Raw JSON', 'Cleaned JSON');

echo "Creating HTML dirs...\n";

mkdir(HTML_XSS_DIR, 0777, true);
mkdir(HTML_NOXSS_DIR, 0777, true);

echo "Starting XSS cleanup:\n";

// Loop until we reach the end of the file.
$line = 0;
while (!$fixture->eof()) {
    $line++;
    $xss = str_replace("\n",'',$fixture->fgets());
    $noXss = XSSClean::clean($xss);

    $json = getJson($xss);
    $clean = getJson($noXss);

    $htmlXss = getHTML("#{$line} With XSS", $json);
    $htmlNoXss = getHTML("#{$line} No XSS", $clean);

    saveHTML(HTML_XSS_DIR . "{$line}_xss.html", $htmlXss);
    saveHTML(HTML_NOXSS_DIR . "{$line}_noxss.html", $htmlNoXss);
    writeCSVLine($report, $line, $xss, $json, $clean);
}


// Unset the file to call __destruct(), closing the file handle.
$fixture = null;
$report = null;

echo "Finished.\n";
