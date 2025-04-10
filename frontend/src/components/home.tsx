
import {
    useEffect
} from 'react';


import { useSession } from 'next-auth/react';
import { useRouter } from 'next/navigation';

const Home = () => {

    const { data: session, status } = useSession();
    const router = useRouter();

    useEffect(() => {
        if (status === 'unauthenticated') {
            router.push('/login');
        } else {
            router.push('/dashboard');
        }
    }, [status, router, session]);

    if (status === 'loading') {
        return <p>Loading...</p>;
    } else {

    }

    return (
        <div className="w-full">Home Page</div>
    )
}

export default Home