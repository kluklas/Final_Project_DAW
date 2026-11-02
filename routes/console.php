<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:uploads-rpa')->everyTenMinutes();
