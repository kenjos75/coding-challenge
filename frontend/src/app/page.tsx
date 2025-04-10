
'use client'
import { SessionProvider } from 'next-auth/react';
import HomeComponent from '@/components/home'

export default function Home() {
  
  return (
    <div className="w-full">
      <SessionProvider>
        <HomeComponent />
      </SessionProvider>
    </div>
  );
}
