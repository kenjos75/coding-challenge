

import { useSession } from 'next-auth/react';
import { signOut } from 'next-auth/react';

import Link from "next/link";
const Sidebar = () => {

    const _logout = () => {
        signOut({ callbackUrl: '/login' })
    }
    const { data: session, status } = useSession();
    return (
    <div className="w-64 bg-gray-800 text-white">
        <div className="p-4 text-2xl font-semibold">
        Admin Panel
        </div>
        <ul className="mt-8 space-y-2">
            <li>
                <Link href="/dashboard" className="block py-2 px-4 text-gray-300 hover:bg-gray-700">
                Dashboard
                </Link>
            </li>
            {
                session?.user?.role == 'employer' &&
                <li>
                    <Link href="/create-job"  className="block py-2 px-4 text-gray-300 hover:bg-gray-700">
                        Create Job
                    </Link>
                </li>
            }
            <li>
                <a onClick={_logout} href="#" className="block py-2 px-4 text-gray-300 hover:bg-gray-700">
                Sign out
                </a>
            </li>
        </ul>
    </div>       
    )
}
export default Sidebar