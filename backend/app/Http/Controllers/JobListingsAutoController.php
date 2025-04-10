<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\JobListing;

class JobListingsAutoController extends Controller
{
    // Method to fetch and parse the job data from the XML
    public function getJobs()
    {
        // Define the XML URL
        $xmlUrl = 'https://mrge-group-gmbh.jobs.personio.de/xml';

        // Fetch the XML content from the URL
        $xmlContent = file_get_contents($xmlUrl);

        // Parse the XML content with SimpleXML (no additional tools needed)
        $xml = simplexml_load_string($xmlContent);

        // Check if the XML loaded successfully
        if ($xml === false) {
            return response()->json(['error' => 'Failed to load XML'], 500);
        }

        //get the jobs from database
        $jobListings = JobListing::all();

        // Loop through the positions and create an array of job listings
        $jobs = [];
        foreach ($xml->position as $position) {
            $jobs[] = [
                'id' => (string) $position->id,
                'title' => (string) $position->name,
                'description' => strip_tags((string) $position->jobDescriptions->jobDescription->value), // Strip HTML tags for the description
                'url' => 'https://mrge-group-gmbh.jobs.personio.de/job/' . (string) $position->id, // Assuming the URL structure
            ];
        }

        $mergeJobs = [];
        if (count($jobListings) > 0 ) {
            foreach ($jobListings as $jobListing) {
                array_push($mergeJobs, [
                    'title' => $jobListing->title,
                    'description' => $jobListing->description,
                    'url' => ''
                ]);
            }
        }

        if (count($jobs) > 0 ) {
            foreach ($jobs as $job) {
                array_push($mergeJobs, [
                    'title' => $job['title'],
                    'description' => $job['description'],
                    'url' => $job['url']
                ]);
            }
        }


        return response()->json($mergeJobs);

    }
}
