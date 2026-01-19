import { cookies } from 'next/headers';
import { verifyToken } from '@/app/middleware/authMiddleware';
import AdminBlogPageContent from '@/app/components/molecules/AdminBlogPage';
import AccessDenied from '@/app/components/molecules/AccessDenied';

export default async function AdminBlogPage() {
  const cookieStore = cookies();
  const token = cookieStore.get('admin_token')?.value;

  // Verifica il token sul lato server
  const admin = await verifyToken(token || '');
  if (!admin) {
    return <AccessDenied redirectPath="/login" delay={5000} />;
  }

  // Renderizza il contenuto della dashboard
  return <AdminBlogPageContent />;
}