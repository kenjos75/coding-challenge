'use client';

import { useState } from 'react';
import { useSession } from 'next-auth/react';
import axios from 'axios'

const JobCreate = ({ accessToken }) => {
  const [title, setTitle] = useState<string>('');
  const [description, setDescription] = useState<string>('');
  const [submitting, setSubmitting] = useState<false>(false)

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    if ( !submitting ) {
        setSubmitting(true)

        try {
            const response = await axios.post(
                `${process.env.NEXT_PUBLIC_API_INTERNAL_HOST}/api/job-listings`,
                {
                    title,
                    description
                },
                {
                    headers: {
                        Authorization: `Bearer ${accessToken}`,
                    },
                }
            );

            setSubmitting(false)
        
            if (response.data) {
                alert('Successfully created job.');
            }
        
        } catch (error) {
            console.error("Error creating job:", error);
        }
    }
    
    
  }


  return (
    <form onSubmit={handleSubmit} className="max-w-md mx-auto p-6 bg-white rounded-2xl shadow-md space-y-4">
      <h2 className="text-xl font-semibold text-gray-800">Post a Job</h2>


        <div>
            <label className="block text-sm">Title</label>
            <input
            type="text"
            className="w-full border rounded px-3 py-2"
            value={title}
            onChange={(e) => setTitle(e.target.value)}
            required
            />
        </div>
        <div>
            <label className="block text-sm">Description</label>
            <textarea
            className="w-full border rounded px-3 py-2"
            value={description}
            onChange={(e) => setDescription(e.target.value)}
            required
            />
        </div>
      <button
        type="submit"
        className="w-full bg-indigo-600 text-white py-2 px-4 rounded-xl hover:bg-indigo-700 transition"
      >
        {
            submitting ? 'Submitting' : 'Submit'
        }
      </button>
    </form>
  );
}

export default JobCreate