import { prisma } from "@/lib/prisma";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { MapPin, Eye, FolderTree, Users, BookMarked } from "lucide-react";

export default async function DashboardPage() {
  const [venueCount, sceneCount, categoryCount, userCount, articleCount] =
    await Promise.all([
      prisma.venue.count(),
      prisma.scene.count(),
      prisma.category.count(),
      prisma.user.count(),
      prisma.wikiArticle.count(),
    ]);

  const stats = [
    { label: "Venues", value: venueCount, icon: MapPin },
    { label: "Scenes", value: sceneCount, icon: Eye },
    { label: "Kategori", value: categoryCount, icon: FolderTree },
    { label: "Users", value: userCount, icon: Users },
    { label: "Artikel Wiki", value: articleCount, icon: BookMarked },
  ];

  return (
    <div>
      <h1 className="text-2xl font-bold tracking-tight mb-6">Dashboard</h1>
      <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
        {stats.map((stat) => (
          <Card key={stat.label}>
            <CardHeader className="flex flex-row items-center justify-between pb-2">
              <CardTitle className="text-sm font-medium text-muted-foreground">
                {stat.label}
              </CardTitle>
              <stat.icon className="size-4 text-muted-foreground" />
            </CardHeader>
            <CardContent>
              <p className="text-2xl font-bold">{stat.value}</p>
            </CardContent>
          </Card>
        ))}
      </div>
    </div>
  );
}
