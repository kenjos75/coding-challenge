// app/layout.tsx
import './globals.css';
import type { Metadata } from 'next';
import { ReactNode } from 'react';
import Providers from './providers'; // Update this if you don't use Providers

export const metadata: Metadata = {
  title: 'MySite',
  description: 'A simple layout built with Tailwind CSS',
};

export default function RootLayout({ children }: { children: ReactNode }) {
  return (
    
    <Providers>
    <html lang="en">
      <body className="bg-gray-50 text-gray-800 font-sans">
        <nav className="bg-white shadow-md">
          <div className="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 className="text-2xl font-bold text-blue-600">{'Coding Challenge'}</h1>
          </div>
        </nav>
        <main>
            {children}
        </main>
      </body>
    </html>
    </Providers>
  );
}
