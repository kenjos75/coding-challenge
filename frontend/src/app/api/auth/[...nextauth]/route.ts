import NextAuth from 'next-auth';
import CredentialsProvider from 'next-auth/providers/credentials';
import axios from "axios";
const handler = NextAuth({
  providers: [
    CredentialsProvider({
      name: 'Credentials',
      credentials: {
        email: { label: "Email", type: "email" },
        password: { label: "Password", type: "password" }
      },
      async authorize(credentials) {
        // Replace this with real DB validation
        try {
            const res = await axios.post(
                //`${process.env.API_URL}/api/auth/login/`,     
                'http://coding-challenge-laravel-service:8000/api/auth/login/',
                {
                email: credentials.email,
                password: credentials.password,
                },
            );
        const user = res.data;

        if (user) {
            return user;
        } else {
            return null;
        }
        } catch (error) {
            return null;
        }

      }
    })
  ],
  session: {
    strategy: 'jwt',
  },
  secret: process.env.NEXTAUTH_SECRET,
  callbacks: {
    async jwt({ token, user }) {
      // Store accessToken in JWT on initial login
      if (user) {
        token.accessToken = user.access_token;
        token.user = user.user
      }
      return token;
    },
    async session({ session, token }) {
      // Send accessToken to client
      session.accessToken = token.accessToken;
      session.user = token.user;
      return session;
    }
  },
});

export { handler as GET, handler as POST };
