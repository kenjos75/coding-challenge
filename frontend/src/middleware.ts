// middleware.ts
import { withAuth } from 'next-auth/middleware';
import { NextResponse } from 'next/server';

export default withAuth(
  function middleware(req) {
    const token = req.nextauth.token;

    // If there is no token, or the user is not authenticated, redirect to login
    if (!token?.accessToken) {
      return NextResponse.redirect(new URL('/login', req.url));
    }

    return NextResponse.next();
  },
  {
    callbacks: {
      authorized: ({ token }) => {
        // Only allow if token exists (user is authenticated)
        // Make sure access token and user object exist
        return !!token?.accessToken && !!token?.user;
      },
    },
    pages: {
      signIn: '/login', // custom login page
    },
  }
);

// Apply middleware only to these routes:
export const config = {
  matcher: ['/dashboard/:path*'], // Protect routes under /dashboard
};
