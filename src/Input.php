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

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
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
            if (empty($datum['A']) || empty($datum['B'])) {
                throw new \Exception('Unexpected format of file people.csv. Try to check a delimiter matching.');
            }
            $users[$datum['A']] = $datum['B'];
        }
        return $users;
    }
}