import Link from "next/link";
import { redirect } from "next/navigation";
import { auth } from "@/lib/auth";
import AdminSidebar from "./sidebar";
import AdminHeader from "./header";

export default async function AdminLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  const session = await auth();

  if (!session?.user || session.user.role !== "admin") {
    redirect("/login");
  }

  return (
    <div className="min-h-screen bg-muted/40">
      <AdminSidebar />
      <div className="pl-64">
        <AdminHeader user={session.user} />
        <main className="p-6">{children}</main>
      </div>
    </div>
  );
}
