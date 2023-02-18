<?php

namespace App\Http\Controllers;

use App\Models\CsvData;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\CsvImportRequest;
use App\Services\ImportCsvService;
use App\Services\DateCalculationsService;
use Session;

class ImportController extends Controller
{
    public function __construct(
        private ImportCsvService $importCsvService, 
        private dateCalculationsService $dateCalculationsService
    )
    {
    }

    public function mappingImport(CsvImportRequest $request)
    {
        $headings = $this->importCsvService->prepareHeadings($request);
        $csvData = $this->importCsvService->prepareCsvData($request);
        $csvDataFile = $this->importCsvService->prepareCsvDataFile($request);

        return view('import_fields', [
            'headings' => $headings,
            'csv_data' => $csvData,
            'csv_data_file' => $csvDataFile
        ]);
    }

    public function processImport(Request $request)
    {
        $startDate = now();
        $data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        $succesRecords = $errorRecords = 0;
        $usersToSave = [];

        foreach ($csv_data as $row) {
            foreach (config('app.db_imported_fields') as $index => $field) {
                if ($data->csv_header) {
                    $index = $field;
                } 
                if ($this->importCsvService->checkRequiredFieldIsEmpty($field, config('app.db_imported_required_fields'), $row[$request->fields[$index]])) {
                    $errorRecords++;
                    continue 2;    
                }
                $usersToSave[$succesRecords][$field] = $row[$request->fields[$index]];
            }
            $succesRecords++;
        }

        User::insert($usersToSave);

        return redirect()
            ->route('users.index')
            ->with('success', 
                'Import zakończony w czasie '.
                $this->dateCalculationsService->getSecondsFromDate($startDate).
                ' sekund. '.
                $succesRecords.
                ' rekordów zapisano. Ominiętych rekordów: '
                . $errorRecords. '.'
            );
    }
}