// app/(user)/layout.tsx

import Header from "../components/atoms/Header";
import Footer from "../components/atoms/Footer";

export default function UserLayout({ children }: { children: React.ReactNode }) {
  return (<>
      <Header />
      <main className="flex-grow container mx-auto px-4 py-8">{children}</main>
      <Footer />
      </>
  );
}