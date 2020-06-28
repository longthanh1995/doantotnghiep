<?php namespace App\Repositories;

interface AppointmentTypeRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    public function findAllOrderByName();

    public function findActiveOrderByName();
}