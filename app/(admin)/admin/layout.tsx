import { cookies } from 'next/headers';
import { verifyToken } from '@/app/middleware/authMiddleware';
import AccessDenied from '@/app/components/molecules/AccessDenied';

export default async function AdminLayout({ children }: { children: React.ReactNode }) {
  const cookieStore = cookies();
  const token = cookieStore.get('admin_token')?.value;

  // Verifica il token sul lato server
  const admin = await verifyToken(token || '');
  if (!admin) {
    return <AccessDenied redirectPath="/login" delay={5000} />;
  }

  // Se il token è valido, renderizza il contenuto delle pagine figlie
  return <>{children}</>;
}