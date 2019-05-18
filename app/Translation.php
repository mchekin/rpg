<?php

namespace App;

use Stevebauman\Translation\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use TranslationTrait;

    /**
     * The locale translations table.
     *
     * @var string
     */
    protected $table = 'translations';

    /**
     * The fillable locale translation attributes.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'translation_id',
        'translation',
    ];

    /**
     * {@inheritdoc}
     */
    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    /**
     * {@inheritdoc}
     */
    public function parent()
    {
        return $this->belongsTo(self::class);
    }
}
