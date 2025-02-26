// app/(admin)/layout.tsx
import { cookies } from 'next/headers';
import AdminHeader from '../../components/atoms/AdminHeader';
import AccessDenied from '../../components/molecules/AccessDenied';
import { verifyToken } from '../../middleware/authMiddleware';
import Footer from '../../components/atoms/Footer';

export default async function AdminLayout({ children }: { children: React.ReactNode }) {
  const cookieStore = cookies();
  const token = cookieStore.get('admin_token')?.value;

  const admin = await verifyToken(token || '');
  if (!admin) {
    return <AccessDenied redirectPath="/login" delay={5000} />;
  }

  return (<>
      <AdminHeader />
      <main className="flex-grow container mx-auto px-4 py-8">{children}</main>
      <Footer />
        </>
  );
}