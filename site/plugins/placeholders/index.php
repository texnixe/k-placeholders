<?php
use Kirby\Cms\App as Kirby;

Kirby::plugin('cookbook/placeholders', [
	'fieldMethods' => [
		'toOptions' => function($field) {
			$result = [];
			foreach ($field->toStructure() as $option) {
				if ($option->key()->isNotEmpty()) {
					$result[$option->key()->value()] = match ($option->datatype()->value()) {
						'date' => $option->date()->toDateDiff(),
						'text' => $option->text()->value(),
					};
				}
			}
			return $result;
		},
		'replace' => function ($field, array $placeholders = []) {
			$field->value = Str::template($field->value, $placeholders);

			return $field;
		},
		'toDateDiff' => function($field) {
				$date    = new DateTime($field->toDate('Y-m-d'));
				$current = new DateTime('now');

				$date->setTimezone(new DateTimeZone('Europe/Berlin'));
				$current->setTimezone(new DateTimeZone('Europe/Berlin'));

				$diff = $current->diff($date);

				return $diff->format('%y years');
		}
	]
]);