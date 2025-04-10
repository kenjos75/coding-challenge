
'use client'

import { useSession } from 'next-auth/react';

import {
  useEffect,
  useState,
  useCallback
} from 'react'

import dynamic from "next/dynamic";

// Dynamically import Echo with SSR disabled
//const initializeEcho = dynamic(() => import("../../lib/echo"), { ssr: false });

import {
  getEcho
} from '../../lib/echo'
import axios from 'axios'
import JobListings from '@/components/job-listings';

export default function Dashboard() {

    const [listings, setListings] = useState([])  
    const { data: session, status } = useSession();
    const [echo, setEcho] = useState(null);

    const fetchLists = useCallback(async () => {
      
      if ( session ) {
        try {
          const response = await axios.get(
            `${process.env.NEXT_PUBLIC_API_INTERNAL_HOST}/api/all-jobs`,
            {
              headers: {
                Authorization: `Bearer ${session.accessToken}`,
              }
            },
          );
          setListings(response.data);
          
        } catch (error) {
          console.error("Error fetching files:", error);
        }
      }
      
    
    }, [session]);


    

    useEffect(() => {
      fetchLists();
    }, [fetchLists]);

    useEffect(() => {

      const echo = getEcho();

      if (!echo) {
        console.error("Echo is not initialized. This likely means the code is running on the server.");
        return;
      }

      if ( session ) {
        try {
          // Subscribe to the channel
          const channel = echo.channel(`notifications.${session?.user?.id}`);
          channel.listen(".notification.sent", (event) => {
            console.log("Event received:", event);
            alert('New job was posted. Please refresh the page.')
          });
    
          // Cleanup on unmount
          return () => {
            echo.leave(`notifications.${session?.user?.id}`);
          };
        } catch (error) {
          console.error("Error subscribing to channel:", error);
        }
      }
      
    }, [session]);
    
    
    if (status === 'loading') return <p>Loading...</p>;
    return (
        <div className="flex-1 p-6 bg-gray">
            <div className="text-3xl font-semibold mb-6">
                Hello Welcome { session.user?.name }
            </div>

            {/* Additional Content */}
            <div className="mt-6">
                <JobListings 
                  items={listings}
                />
            </div>
        </div>
  );
}
