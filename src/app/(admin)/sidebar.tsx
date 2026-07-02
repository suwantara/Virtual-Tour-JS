"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { cn } from "@/lib/utils";
import {
  LayoutDashboard,
  MapPin,
  Eye,
  Crosshair,
  FolderTree,
  BookOpen,
  BookMarked,
  Users,
  Settings,
} from "lucide-react";

const navItems = [
  { href: "/dashboard", label: "Dashboard", icon: LayoutDashboard },
  { href: "/dashboard/venues", label: "Venues", icon: MapPin },
  { href: "/dashboard/scenes", label: "Scenes", icon: Eye },
  { href: "/dashboard/hotspots", label: "Hotspots", icon: Crosshair },
  { href: "/dashboard/categories", label: "Kategori", icon: FolderTree },
  { href: "/dashboard/wiki-categories", label: "Kategori Wiki", icon: BookOpen },
  { href: "/dashboard/wiki-articles", label: "Artikel Wiki", icon: BookMarked },
  { href: "/dashboard/users", label: "Users", icon: Users },
  { href: "/dashboard/settings", label: "Pengaturan", icon: Settings },
];

export default function AdminSidebar() {
  const pathname = usePathname();

  return (
    <aside className="fixed inset-y-0 left-0 z-40 w-64 border-r bg-card">
      <div className="flex h-14 items-center border-b px-4">
        <Link href="/dashboard" className="font-semibold text-sm">
          Admin Tambawu
        </Link>
      </div>
      <nav className="p-3 space-y-1">
        {navItems.map((item) => {
          const isActive =
            item.href === "/dashboard"
              ? pathname === "/dashboard"
              : pathname.startsWith(item.href);
          return (
            <Link
              key={item.href}
              href={item.href}
              className={cn(
                "flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm font-medium transition-colors",
                isActive
                  ? "bg-primary/10 text-primary"
                  : "text-muted-foreground hover:bg-muted hover:text-foreground"
              )}
            >
              <item.icon className="size-4" />
              {item.label}
            </Link>
          );
        })}
      </nav>
    </aside>
  );
}
