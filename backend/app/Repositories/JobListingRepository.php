<?php

namespace App\Repositories;

use App\Models\JobListing;
use Illuminate\Database\Eloquent\Collection;

class JobListingRepository implements JobListingRepositoryInterface
{
    /**
     * Create a new job listing.
     *
     * @param array $data
     * @return JobListing
     */
    public function create(array $data): JobListing
    {
        // You can include any validation, transformation, or additional logic here
        return JobListing::create($data);
    }

    /**
     * Get all job listings.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return JobListing::all();
    }

    /**
     * Get a job listing by ID.
     *
     * @param int $id
     * @return JobListing|null
     */
    public function getById(int $id): ?JobListing
    {
        return JobListing::find($id);
    }

    /**
     * Update a job listing by ID.
     *
     * @param int $id
     * @param array $data
     * @return JobListing
     */
    public function update(int $id, array $data): JobListing
    {
        // Retrieve the job listing
        $jobListing = $this->getById($id);

        if ($jobListing) {
            // Update the job listing with new data
            $jobListing->update($data);
        }

        return $jobListing;
    }

    /**
     * Delete a job listing by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        // Retrieve the job listing
        $jobListing = $this->getById($id);

        if ($jobListing) {
            // Delete the job listing
            return $jobListing->delete();
        }

        return false; // Return false if the job listing was not found
    }
}
