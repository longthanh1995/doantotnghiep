<?php

namespace App\Services;

/**
 * Interface BroadcastServiceInterface
 * @package App\Services
 */
/**
 * Interface BroadcastServiceInterface
 * @package App\Services
 */
/**
 * Interface BroadcastServiceInterface
 * @package App\Services
 */
interface BroadcastServiceInterface extends BaseServiceInterface
{
    /**
     * @return mixed
     */
    public function index();

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);

    /**
     * @param $id
     * @return mixed
     */
    public function show($id);

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @param array $userIds
     * @return mixed
     */
    public function addUsers($id, array $userIds = []);

    public function getTopics();
}