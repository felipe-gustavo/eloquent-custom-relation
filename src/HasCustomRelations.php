<?php

namespace LaravelCustomRelation;

use Closure;

use LaravelCustomRelation\Relations\CustomMany;
use LaravelCustomRelation\Relations\CustomOne;

trait HasCustomRelations {
    /**
     * Create a new model instance for a related model.
     *
     * @param  string  $class
     * @return mixed
     */
    protected function newRelatedInstance($class) {
        return tap(new $class, function ($instance) {
            if (! $instance->getConnectionName()) $instance->setConnection($this->connection);
        });
    }

    /**
     * Define a custom relationship many.
     *
     * @param  string  $related
     * @param  string  $baseConstraints
     * @param  string  $eagerConstraints
     * @return \App\Services\Database\Relations\Custom
     */
    public function customMany(
        $related,
        Closure $baseConstraints,
        Closure $eagerConstraints,
        array $eagerParentRelations = null,
        string $localKey = null,
        string $foreignKey = null
    ) {
        $instance = $this->newRelatedInstance($related);
        $query = $instance->newQuery();

        return new CustomMany($query, $this, $baseConstraints, $eagerConstraints, $eagerParentRelations, $localKey, $foreignKey);
    }

    /**
     * Define a custom relationship one.
     *
     * @param  string  $related
     * @param  string  $baseConstraints
     * @param  string  $eagerConstraints
     * @return \App\Services\Database\Relations\Custom
     */
    public function customOne(
        $related,
        Closure $baseConstraints,
        Closure $eagerConstraints,
        array $eagerParentRelations = null,
        string $localKey = null,
        string $foreignKey = null
    ) {
        $instance = $this->newRelatedInstance($related);
        $query = $instance->newQuery();

        return new CustomOne($query, $this, $baseConstraints, $eagerConstraints, $eagerParentRelations, $localKey, $foreignKey);
    }
}
