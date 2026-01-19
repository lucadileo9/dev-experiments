import { cookies } from 'next/headers';

export const POST = async (request: Request) => {
  const body = await request.json();
  const { token } = body;

  if (!token) {
    return new Response('Token mancante', { status: 400 });
  }

  // Imposta il cookie con il token
  cookies().set('admin_token', token, { path: '/', maxAge: 3600 }); // Scade dopo 1 ora

  return new Response('Token salvato', { status: 200 });
};