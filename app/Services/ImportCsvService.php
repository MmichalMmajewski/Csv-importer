<?php

namespace App\Services;

use App\Models\CsvData;
use App\Http\Requests\CsvImportRequest;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class ImportCsvService 
{
    public function prepareHeadings(CsvImportRequest $request)
    {
        if ($request->has('header')) {
            $headings = (new HeadingRowImport)->toArray($request->file('csv_file'));
        
        } else {
            $headings = [
                '0' =>
                    [
                        '0' => config('app.db_imported_fields'),
                    ],
            ];
        }

        return $headings;
    }

    public function prepareCsvData(CsvImportRequest $request)
    {
        $data = $this->prepareData($request);

        if (count($data) > 0) {
            $csvData = array_slice($data, 0, 2);
        } else {
            return redirect()->back();
        }

        return $csvData;
    }

    public function prepareCsvDataFile(CsvImportRequest $request)
    {
        $data = $this->prepareData($request);

        if (count($data) > 0) {
            $csvDataFile = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data)
            ]);
        } else {
            return redirect()->back();
        }

        return $csvDataFile;
    }

    public function checkRequiredFieldIsEmpty(string $fieldName, array $requiredFields, $data)
    {
        if (in_array($fieldName, $requiredFields)) {
            if (empty($data)) {
                return true;
            }
        }

        return false;
    }
    
    private function prepareData(CsvImportRequest $request)
    {
        if ($request->has('header')) {
            $data = Excel::toArray(new UsersImport, $request->file('csv_file'))[0];
        } else {
            $data = array_map('str_getcsv', file($request->file('csv_file')->getRealPath()));
            /*
            * TODO: Get data in that way, that current selected header will be working on FE, 
            * when there are not headers in input file.
            */
        }
        
        return $data;
    }
}
