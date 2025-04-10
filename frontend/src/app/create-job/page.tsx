
'use client'

import { useSession } from 'next-auth/react';
import JobListings from '@/components/job-listings';
import JobCreate from '@/components/job-create';

export default function CreateJob() {

    const { data: session, status } = useSession();

    if (status === 'loading') return <p>Loading...</p>;
    return (
        <div className="flex-1 p-6 bg-gray-100">
            <div className="text-3xl font-semibold mb-6">
                Hello Welcome { session.user?.name }
            </div>
            {/* Additional Content */}
            <div className="mt-6">
                <JobCreate accessToken={session.accessToken}/>
            </div>
        </div>
  );
}
