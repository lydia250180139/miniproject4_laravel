<?php
use Illuminate\Support\Facades\Artisan;
Artisan::command('project:info', function () { $this->info('Galeri Laptop Inventory Management System - Laravel 12'); })->purpose('Display project information');
