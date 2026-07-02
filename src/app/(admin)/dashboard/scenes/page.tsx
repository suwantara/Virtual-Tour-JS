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

async function deleteScene(formData: FormData) {
  "use server";
  const id = parseInt(formData.get("id") as string);
  try {
    await prisma.scene.delete({ where: { id } });
  } catch {
    redirect("/dashboard/scenes?error=Gagal+menghapus+data.+Data+mungkin+masih+digunakan.");
  }
  revalidatePath("/dashboard/scenes");
}

export default async function ScenesPage() {
  const scenes = await prisma.scene.findMany({
    include: { venue: { select: { name: true } } },
    orderBy: [{ venueId: "asc" }, { order: "asc" }],
  });

  return (
    <div>
      <h1 className="text-2xl font-bold tracking-tight mb-6">Scenes</h1>

      <Card>
        <CardHeader className="flex-row items-center justify-between">
          <CardTitle>Semua Scene</CardTitle>
          <Button size="sm">
            <Plus className="size-4" />
            Tambah
          </Button>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Nama</TableHead>
                <TableHead>Venue</TableHead>
                <TableHead>Urutan</TableHead>
                <TableHead>Status</TableHead>
                <TableHead className="w-24">Aksi</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {scenes.length === 0 && (
                <TableRow>
                  <TableCell colSpan={5} className="text-center text-muted-foreground py-8">
                    Belum ada scene.
                  </TableCell>
                </TableRow>
              )}
              {scenes.map((scene) => (
                <TableRow key={scene.id}>
                  <TableCell className="font-medium">{scene.name}</TableCell>
                  <TableCell>{scene.venue.name}</TableCell>
                  <TableCell>{scene.order}</TableCell>
                  <TableCell>
                    {scene.isPublished ? (
                      <Badge variant="default">Published</Badge>
                    ) : (
                      <Badge variant="secondary">Draft</Badge>
                    )}
                  </TableCell>
                  <TableCell>
                    <div className="flex items-center gap-1">
                      <Button size="icon-xs" variant="ghost">
                        <Pencil className="size-3.5" />
                      </Button>
                      <form action={deleteScene}>
                        <input type="hidden" name="id" value={scene.id} />
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
