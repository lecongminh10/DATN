<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductsAndVariantsExport implements WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $selectedColumnsPro;
    protected $selectedColumnsPro_Variant;

    public function __construct($selectedColumnsPro, $selectedColumnsPro_Variant)
    {
        $this->selectedColumnsPro = $selectedColumnsPro;
        $this->selectedColumnsPro_Variant = $selectedColumnsPro_Variant;
    }

    public function sheets(): array
    {
        return [
            new ProductExport($this->selectedColumnsPro),
            new ProductVariantExport($this->selectedColumnsPro_Variant)
        ];
    }
}
