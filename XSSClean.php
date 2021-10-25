<?php

class XSSClean
{
    /**
     * Apply XSS cleanning
     * 
     * @param  string  $raw  Raw XSS input
     * @return string
     */
    public static function clean(string $raw) : string
    {
        // Test here your code
        return htmlspecialchars($raw);
    }
}