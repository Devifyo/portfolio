<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = ['name', 'subject', 'body'];

    public static function render(string $name, array $vars): array
    {
        $template = static::where('name', $name)->firstOrFail();

        $search  = array_map(fn($k) => '{{'.$k.'}}', array_keys($vars));
        $replace = array_values($vars);

        return [
            'subject' => str_replace($search, $replace, $template->subject),
            'body'    => str_replace($search, $replace, $template->body),
        ];
    }
}
