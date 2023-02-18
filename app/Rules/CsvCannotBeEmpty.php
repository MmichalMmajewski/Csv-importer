<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\ImportCsvService; 
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class CsvCannotBeEmpty implements Rule
{

    private const MIN_NUMBER_OF_ROWS = 2;
    private const MAX_NUMBER_OF_ROWS = 50;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->importCsvService = app(ImportCsvService::class);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $numberOfRows = count(Excel::toArray(new UsersImport, $value)[0][0]);

        return $numberOfRows >= self::MIN_NUMBER_OF_ROWS && $numberOfRows <= self::MAX_NUMBER_OF_ROWS;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Nie można zaimportować pustego pliku.';
    }
}
