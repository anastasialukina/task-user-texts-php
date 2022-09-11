<?php

namespace App;

class Input
{
    private string $delimiter;

    /**
     * @param string $delimiter
     */
    public function __construct(string $delimiter)
    {
        $this->delimiter = $delimiter;
    }

    public function inputPeopleFile(): array
    {
        $inputFileType = 'Csv';
        $inputFileName = './csv/people.csv';

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setDelimiter($this->delimiter);
        $spreadsheet = $reader->load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        unset($sheetData["1"]);

        $users = [];
        foreach ($sheetData as $datum) {
            $users[$datum['A']] = $datum['B'];
        }
        return $users;
    }
}