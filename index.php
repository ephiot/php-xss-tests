<?php

require_once './helpers.php';
require_once './XSSClean.php';

const REPORT_DIR = './report/';
const HTML_DIR = './html/';

$currTime = date('YmdHisw');

$reportFilepath = REPORT_DIR . "report.{$currTime}.csv";

$htmlSubDir = HTML_DIR . "/{$currTime}/";
$htmlXssDir = "{$htmlSubDir}/xss/";
$htmlNoXssDir = "{$htmlSubDir}/no-xss/";

echo "Loading XSS fixture file...\n";

$fixture = new SplFileObject('xss-fixture.txt');

echo "Openning CSV report file...\n";

mkdir(REPORT_DIR, 0777, true);
$report = new SplFileObject($reportFilepath, 'w+');
writeCSVLine($report, 'Id', 'XSS', 'Raw JSON', 'Cleaned JSON');

echo "Creating HTML dirs...\n";

mkdir($htmlXssDir, 0777, true);
mkdir($htmlNoXssDir, 0777, true);

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

    saveHTML($htmlXssDir . "{$line}_xss.html", $htmlXss);
    saveHTML($htmlNoXssDir . "{$line}_noxss.html", $htmlNoXss);
    writeCSVLine($report, $line, $xss, $json, $clean);
}


// Unset the file to call __destruct(), closing the file handle.
$fixture = null;
$report = null;

echo "Finished.\n";
