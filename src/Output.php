<?php

namespace App;

class Output
{
    public function getTextFiles(): array
    {
        $dir = 'texts';
        $files = scandir($dir);
        $texts = [];

        foreach ($files as $file) {
            if (str_starts_with($file, '.')) {
                continue;
            }
            $filePath = $dir . '/' . $file;
            $content = file_get_contents($filePath);
            $user = explode("-", $file);
            $texts[$user[0]][] = $content;
        }
        return $texts;
    }

}