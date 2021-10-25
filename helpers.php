<?php

/**
 * Generate a JSON with XSS injected
 * 
 * @param  string  $xss  XSS instruction
 * @return string
 */
function getJson(string $xss) : string
{
    return json_encode([
        'a' => 'safe info',
        'b' => $xss
    ]);
}

/**
 * Write a CSV line
 * 
 * @param  string  ...$cols  Cols values
 * @return void
 */
function writeCSVLine(SplFileObject $file, string ...$cols)
{
    $cleanWQuotes = array_map(function ($col) {
        return str_replace(["\n",'\\','"'], ['\\n','\\\\','\\"'], $col);
    }, $cols);
    $line = '"' . implode('","', $cleanWQuotes) . '"' . "\n";
    $file->fwrite($line);
}

/**
 * Generate HTML with title and body injected
 * 
 * @param  string  $title  HTML title tag content
 * @param  string  $body  HTML body tag content
 * @return string
 */
function getHTML(string $title, string $body) : string
{
    return str_replace(['{title}', '{body}'], [$title, $body], file_get_contents('./template.html'));
}

/**
 * Save HTML
 * 
 * @param  string  $filename  Filename with path
 * @param  string  $html  HTML content
 * @return void
 */
function saveHTML(string $filename, string $html)
{
    if ($dir < 0 || $dir > 1) {
        throw new Exception('ERROR: HTML directory unknown!');
    }
    file_put_contents($filename, $html);
}
