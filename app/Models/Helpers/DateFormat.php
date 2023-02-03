<?php

namespace App\Models\Helpers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait DateFormat
{
    private function changeDateTimeFormat(string $dateTime): string
    {
        return (new Carbon($dateTime))->format('d.m.Y H:i');
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->changeDateTimeFormat($value)
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->changeDateTimeFormat($value)
        );
    }
}
