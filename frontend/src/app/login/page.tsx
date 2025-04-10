
'use client'


import { signIn } from 'next-auth/react';
import { useState } from 'react';
import { useRouter } from 'next/navigation';
import axios from "axios";
export default function Dashboard() {


    const router = useRouter();
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');

    const handleLogin = async (e: React.FormEvent) => {
        e.preventDefault();
        setError('');
        
        const res = await signIn('credentials', {
            redirect: false,
            email,
            password,
        });

        console.log(res)
        if (res?.error) {
            setError('Invalid credentials');
        } else {
            router.push('/dashboard');
        }
    };

    return (
    <div className="max-w-md mx-auto mt-20 p-6 rounded-lg shadow-md">
        <h1 className="text-2xl font-semibold mb-4">Login</h1>
        <form onSubmit={handleLogin} className="space-y-4">
            <div>
                <label className="block text-sm">Email</label>
                <input
                type="email"
                className="w-full border rounded px-3 py-2"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
                />
            </div>
            <div>
                <label className="block text-sm">Password</label>
                <input
                type="password"
                className="w-full border rounded px-3 py-2"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
                />
            </div>
            {error && <p className="text-red-500 text-sm">{error}</p>}
            <button
                type="submit"
                className="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition"
            >
                {'Sign In'}
            </button>
        </form>
    </div>
  );
}
