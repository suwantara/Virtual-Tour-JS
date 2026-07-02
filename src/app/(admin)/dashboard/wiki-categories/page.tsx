import Link from "next/link";
import { revalidatePath } from "next/cache";
import { redirect } from "next/navigation";
import { prisma } from "@/lib/prisma";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { Plus, Pencil, Trash2 } from "lucide-react";

async function deleteWikiCategory(formData: FormData) {
  "use server";
  const id = parseInt(formData.get("id") as string);
  try {
    await prisma.wikiCategory.delete({ where: { id } });
  } catch {
    redirect("/dashboard/wiki-categories?error=Gagal+menghapus+data.+Data+mungkin+masih+digunakan.");
  }
  revalidatePath("/dashboard/wiki-categories");
}

export default async function WikiCategoriesPage() {
  const wikiCategories = await prisma.wikiCategory.findMany({
    include: { _count: { select: { articles: true } } },
    orderBy: { order: "asc" },
  });

  return (
    <div>
      <h1 className="text-2xl font-bold tracking-tight mb-6">
        Kategori Wiki
      </h1>

      <Card>
        <CardHeader className="flex-row items-center justify-between">
          <CardTitle>Semua Kategori Wiki</CardTitle>
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
                <TableHead>Slug</TableHead>
                <TableHead>Ikon</TableHead>
                <TableHead>Urutan</TableHead>
                <TableHead>Artikel</TableHead>
                <TableHead className="w-24">Aksi</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {wikiCategories.length === 0 && (
                <TableRow>
                  <TableCell colSpan={6} className="text-center text-muted-foreground py-8">
                    Belum ada kategori wiki.
                  </TableCell>
                </TableRow>
              )}
              {wikiCategories.map((cat) => (
                <TableRow key={cat.id}>
                  <TableCell className="font-medium">{cat.name}</TableCell>
                  <TableCell className="text-muted-foreground">
                    {cat.slug}
                  </TableCell>
                  <TableCell className="text-muted-foreground">
                    {cat.icon ?? "-"}
                  </TableCell>
                  <TableCell>{cat.order}</TableCell>
                  <TableCell>{cat._count.articles}</TableCell>
                  <TableCell>
                    <div className="flex items-center gap-1">
                      <Button size="icon-xs" variant="ghost">
                        <Pencil className="size-3.5" />
                      </Button>
                      <form action={deleteWikiCategory}>
                        <input type="hidden" name="id" value={cat.id} />
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
