<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 *
 * @method T getRecord()
 *
 * @property T $record
 */
abstract class BaseCreateRecord extends CreateRecord {}
