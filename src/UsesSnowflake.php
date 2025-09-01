<?php

namespace Haritsyp\Snowflake;

trait UsesSnowflake
{
    /**
     * Boot the trait and assign snowflake ID on creating
     */
    protected static function bootUseSnowflake()
    {
        static::saving(function ($model) {
            if (is_null($model->getKey())) {
                $snowflake = app(Snowflake::class);
                $model->{$model->getKeyName()} = $snowflake->nextId();
            }
        });
    }
}
