<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CsvCannotBeEmpty;

class CsvImportRequest extends FormRequest
{
    public function rules(): array
    {
        return [ 
            'csv_file' => ['bail','required', 'mimes:csv', new CsvCannotBeEmpty()]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}