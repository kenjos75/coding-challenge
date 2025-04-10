'use client'
import React from 'react';
import { SessionProvider } from 'next-auth/react';
import { signOut } from 'next-auth/react';
import Sidebar from '@/components/sidebar';
const CreateJobLayout = ({ children }: { children: React.ReactNode }) => {
  return (
    <div className="flex h-screen">

        {/* Main Content */}
        <SessionProvider>
            <Sidebar />
            {children}
        </SessionProvider>
    </div>
  );
};

export default CreateJobLayout;
