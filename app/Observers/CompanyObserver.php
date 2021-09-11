<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Company;
use Illuminate\Support\Str;

class CompanyObserver
{
    public function creating(Company $company) : void
    {
        $company->url = Str::slug($company->name);
        $company->uuid = Str::uuid();
    }

    public function updating(Company $company) : void
    {
        $company->url = Str::slug($company->name);
    }
}
