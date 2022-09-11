<?php

namespace App;

use DateTime;

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

    public function replaceDates(): array
    {
        $textData = $this->getTextFiles();
        $arrayOfFinalData = [];
        foreach ($textData as $keyGroup => $textGroup) {
            $countOfDates = 0;

            foreach ($textGroup as $keyText => $text) {
                $pattern = '/\d{2}\/\d{2}\/\d{2}/';
                $dir = 'output_texts';

                preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);

                if (empty($matches))
                    continue;

                $newText = $text;

                foreach ($matches as $match) {
                    $match = $match[0];
                    $countOfDates++;
                    //dd/mm/yy to mm-dd-yyyy
                    $date = DateTime::createFromFormat('d/m/y', $match);
                    $date = $date->format('m-d-Y');
                    $newText = str_replace($match, $date, $newText);
                }

                $file = $keyGroup . '-' . $keyText + 1 . '.txt';
                $fileName = $dir . '/' . $file;

                file_put_contents($fileName, $newText);
            }
            $arrayOfFinalData[$keyGroup] = $countOfDates;
        }

        return $arrayOfFinalData;
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