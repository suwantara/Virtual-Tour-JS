import Link from "next/link";
import { revalidatePath } from "next/cache";
import { redirect } from "next/navigation";
import { prisma } from "@/lib/prisma";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { Plus, Pencil, Trash2 } from "lucide-react";

async function deleteHotspot(formData: FormData) {
  "use server";
  const id = parseInt(formData.get("id") as string);
  try {
    await prisma.hotspot.delete({ where: { id } });
  } catch {
    redirect("/dashboard/hotspots?error=Gagal+menghapus+data.+Data+mungkin+masih+digunakan.");
  }
  revalidatePath("/dashboard/hotspots");
}

const typeLabels: Record<string, string> = {
  scene: "Pindah Scene",
  info: "Informasi",
  external: "Link Eksternal",
  media: "Media",
};

export default async function HotspotsPage() {
  const hotspots = await prisma.hotspot.findMany({
    include: { scene: { select: { name: true } } },
    orderBy: [{ sceneId: "asc" }, { createdAt: "desc" }],
  });

  return (
    <div>
      <h1 className="text-2xl font-bold tracking-tight mb-6">Hotspots</h1>

      <Card>
        <CardHeader className="flex-row items-center justify-between">
          <CardTitle>Semua Hotspot</CardTitle>
          <Button size="sm">
            <Plus className="size-4" />
            Tambah
          </Button>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Label</TableHead>
                <TableHead>Tipe</TableHead>
                <TableHead>Scene</TableHead>
                <TableHead className="w-24">Aksi</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {hotspots.length === 0 && (
                <TableRow>
                  <TableCell colSpan={4} className="text-center text-muted-foreground py-8">
                    Belum ada hotspot.
                  </TableCell>
                </TableRow>
              )}
              {hotspots.map((hotspot) => (
                <TableRow key={hotspot.id}>
                  <TableCell className="font-medium">{hotspot.label}</TableCell>
                  <TableCell>
                    <Badge variant="outline">
                      {typeLabels[hotspot.type] ?? hotspot.type}
                    </Badge>
                  </TableCell>
                  <TableCell>{hotspot.scene.name}</TableCell>
                  <TableCell>
                    <div className="flex items-center gap-1">
                      <Button size="icon-xs" variant="ghost">
                        <Pencil className="size-3.5" />
                      </Button>
                      <form action={deleteHotspot}>
                        <input type="hidden" name="id" value={hotspot.id} />
                        <Button
                          size="icon-xs"
                          variant="destructive"
                          type="submit"
                        >
                          <Trash2 className="size-3.5" />
                        </Button>
                      </form>
                    </div>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
      </Card>
    </div>
  );
}
