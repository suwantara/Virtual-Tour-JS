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

async function deleteCategory(formData: FormData) {
  "use server";
  const id = parseInt(formData.get("id") as string);
  try {
    await prisma.category.delete({ where: { id } });
  } catch {
    redirect("/dashboard/categories?error=Gagal+menghapus+data.+Data+mungkin+masih+digunakan.");
  }
  revalidatePath("/dashboard/categories");
}

export default async function CategoriesPage() {
  const categories = await prisma.category.findMany({
    include: { _count: { select: { venues: true } } },
    orderBy: { name: "asc" },
  });

  return (
    <div>
      <h1 className="text-2xl font-bold tracking-tight mb-6">Kategori</h1>

      <Card>
        <CardHeader className="flex-row items-center justify-between">
          <CardTitle>Semua Kategori</CardTitle>
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
                <TableHead>Deskripsi</TableHead>
                <TableHead>Venue</TableHead>
                <TableHead className="w-24">Aksi</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {categories.length === 0 && (
                <TableRow>
                  <TableCell colSpan={5} className="text-center text-muted-foreground py-8">
                    Belum ada kategori.
                  </TableCell>
                </TableRow>
              )}
              {categories.map((category) => (
                <TableRow key={category.id}>
                  <TableCell className="font-medium">{category.name}</TableCell>
                  <TableCell className="text-muted-foreground">
                    {category.slug}
                  </TableCell>
                  <TableCell className="max-w-48 truncate">
                    {category.description ?? "-"}
                  </TableCell>
                  <TableCell>{category._count.venues}</TableCell>
                  <TableCell>
                    <div className="flex items-center gap-1">
                      <Button size="icon-xs" variant="ghost">
                        <Pencil className="size-3.5" />
                      </Button>
                      <form action={deleteCategory}>
                        <input type="hidden" name="id" value={category.id} />
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
