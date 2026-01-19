import AdminBlogForm from "@/app/components/molecules/AdminBlogForm";

export default function NewBlogPostPage() {
  return (
    <div>
      <h1 className="text-4xl font-bold mb-8">Nuovo Articolo</h1>
      <AdminBlogForm />
    </div>
  );
}