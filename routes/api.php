<?php

/* TODO: Start creating fresh API routes */
use App\Http\Middleware\VendorMode;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\WeQuizController;