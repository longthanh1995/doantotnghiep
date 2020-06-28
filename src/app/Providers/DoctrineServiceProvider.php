<?php

namespace App\Providers;

use CrEOF\Spatial\DBAL\Types\Geometry\LineStringType;
use CrEOF\Spatial\DBAL\Types\Geometry\PolygonType;
use CrEOF\Spatial\DBAL\Types\Geometry\PointType;
use CrEOF\Spatial\DBAL\Types\GeometryType;
use Illuminate\Support\ServiceProvider;

class DoctrineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \Doctrine\DBAL\Types\Type::addType('point', PointType::class);
        \Doctrine\DBAL\Types\Type::addType('polygon', PolygonType::class);
        \Doctrine\DBAL\Types\Type::addType('linestring', LineStringType::class);
        \Doctrine\DBAL\Types\Type::addType('geometry', GeometryType::class);
    }
}
