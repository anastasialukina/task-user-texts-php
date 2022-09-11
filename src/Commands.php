<?php

namespace App;

class Commands
{
    public function countAverageLineCount(array $users): array
    {
        $textData = $this->getTextFiles();
        $arrayOfFinalData = [];

        foreach ($users as $keyUser => $user) {
            $countOfStrings = 0;
            foreach ($textData as $keyTextGroup => $textGroup) {
                if ($keyTextGroup == $keyUser) {
                    foreach ($textGroup as $text) {
                        $arrayOfStrings = explode("\n", $text);
                        $countOfStrings += count($arrayOfStrings);
                    }
                    $countOfTextGroup = count($textGroup);
                    $arrayOfFinalData[$user] = round($countOfStrings / $countOfTextGroup, 1);
                }
            }
        }

        return $arrayOfFinalData;
    }

    public function replaceDates()
    {

    }

    private function getTextFiles(): array
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