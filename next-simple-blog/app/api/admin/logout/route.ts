import { cookies } from 'next/headers';

export const POST = async () => {
  // Rimuovi il token dal cookie impostandone la durata a 0
  cookies().set('admin_token', '', { path: '/', maxAge: 0 });

  return new Response('Logout effettuato con successo', { status: 200 });
};