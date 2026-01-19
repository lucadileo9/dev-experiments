'use client';
import AdminBlogForm from '@/app/components/molecules/AdminBlogForm';
import { useParams } from 'next/navigation';

export default function EditBlogPostPage() {
  const params = useParams();
  const postId = params.id as string;

  return (
    <div>
      <h1 className="text-4xl font-bold mb-8">Modifica Articolo</h1>
      <AdminBlogForm postId={postId} />
    </div>
  );
}