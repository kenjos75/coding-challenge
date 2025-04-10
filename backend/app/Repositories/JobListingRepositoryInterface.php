<?php

namespace App\Repositories;

use App\Models\JobListing;
use Illuminate\Database\Eloquent\Collection;

interface JobListingRepositoryInterface
{
    /**
     * Create a new job listing.
     *
     * @param array $data
     * @return JobListing
     */
    public function create(array $data): JobListing;

    /**
     * Get all job listings.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get a job listing by ID.
     *
     * @param int $id
     * @return JobListing|null
     */
    public function getById(int $id): ?JobListing;

    /**
     * Update a job listing by ID.
     *
     * @param int $id
     * @param array $data
     * @return JobListing
     */
    public function update(int $id, array $data): JobListing;

    /**
     * Delete a job listing by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
