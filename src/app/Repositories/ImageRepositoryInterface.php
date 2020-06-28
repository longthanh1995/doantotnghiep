<?php

namespace App\Repositories;

interface ImageRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * Get Models with Order.
     *
     * @param  int                                $fileCategory
     * @param  string                                 $order
     * @param  string                                 $direction
     * @param  int                                $offset
     * @param  int                                $limit
     * @return \App\Models\Image[]|\Traversable|array
     */
    public function getByFileCategory($fileCategory, $order, $direction, $offset, $limit);

    /**
     * @param  string                 $url
     * @return \App\Models\Image|null
     */
    public function findByUrl($url);
}
