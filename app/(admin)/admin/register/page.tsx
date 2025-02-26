import { cookies } from 'next/headers';
import { verifyToken } from '@/app/middleware/authMiddleware';
import AddAdmin from '@/app/components/molecules/AddAdmin';
import AccessDenied from '@/app/components/molecules/AccessDenied';

export default async function AddAdminPage() {
  const cookieStore = cookies();
  const token = cookieStore.get('admin_token')?.value;

  // Verifica il token sul lato server
  const admin = await verifyToken(token || '');
  if (!admin) {
    return <AccessDenied redirectPath="/login" delay={5000} />;
  }

  // Se il token è valido, renderizza il contenuto della pagina
  return <AddAdmin />;
}