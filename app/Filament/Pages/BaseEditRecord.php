<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 *
 * @method T getRecord()
 *
 * @property T $record
 */
abstract class BaseEditRecord extends EditRecord {}
