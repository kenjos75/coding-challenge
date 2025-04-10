<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use App\Repositories\JobListingRepositoryInterface;
use Illuminate\Http\Request;
use App\Events\NotificationSent;
use Illuminate\Support\Facades\Auth;


class JobListingsController extends Controller
{
    protected $jobListingRepository;

    public function __construct(JobListingRepositoryInterface $jobListingRepository)
    {
        $this->jobListingRepository = $jobListingRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobListings = $this->jobListingRepository->getAll();
        return response()->json($jobListings);
    }

    /**
     * Store a newly created job listing in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $user = Auth::guard('api')->user();
        $data['user_id'] = $user->id;

        // Use the repository to create the job listing
        $jobListing = $this->jobListingRepository->create($data);


        // Get users who have the role 'job board moderator'
        $usersToNotify = User::role('job-board-moderator')->get();

        // Create a notification for each user with the 'job board moderator' role
        foreach ($usersToNotify as $userToNotify) {
            $notification = Notification::create([
                'user_id' => $userToNotify->id,
                'title' => 'New Job Listing Posted',
                'description' => 'A new job listing titled "' . $jobListing->title . '" has been posted.',
            ]);

            
            // Trigger the event to broadcast the notification
            event(new NotificationSent($notification));

        }


        return response()->json(['message' => 'Job listing posted and users notified']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobListing = $this->jobListingRepository->getById($id);

        if (!$jobListing) {
            return response()->json(['error' => 'Job Listing not found'], 404);
        }

        return response()->json($jobListing);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobListing = $this->jobListingRepository->getById($id);

        if (!$jobListing) {
            return response()->json(['error' => 'Job Listing not found'], 404);
        }

        return response()->json($jobListing);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Use the repository to update the job listing
        $jobListing = $this->jobListingRepository->update($id, $data);

        if (!$jobListing) {
            return response()->json(['error' => 'Job Listing not found'], 404);
        }

        return response()->json($jobListing);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Use the repository to delete the job listing
        if ($this->jobListingRepository->delete($id)) {
            return response()->json(['message' => 'Job Listing deleted successfully']);
        }

        return response()->json(['error' => 'Job Listing not found'], 404);
    }
}

