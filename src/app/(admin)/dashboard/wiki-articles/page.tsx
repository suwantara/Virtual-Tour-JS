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

async function deleteWikiArticle(formData: FormData) {
  "use server";
  const id = parseInt(formData.get("id") as string);
  try {
    await prisma.wikiArticle.delete({ where: { id } });
  } catch {
    redirect("/dashboard/wiki-articles?error=Gagal+menghapus+data.+Data+mungkin+masih+digunakan.");
  }
  revalidatePath("/dashboard/wiki-articles");
}

export default async function WikiArticlesPage() {
  const articles = await prisma.wikiArticle.findMany({
    include: { category: { select: { name: true } } },
    orderBy: [{ wikiCategoryId: "asc" }, { order: "asc" }],
  });

  return (
    <div>
      <h1 className="text-2xl font-bold tracking-tight mb-6">
        Artikel Wiki
      </h1>

      <Card>
        <CardHeader className="flex-row items-center justify-between">
          <CardTitle>Semua Artikel Wiki</CardTitle>
          <Button size="sm">
            <Plus className="size-4" />
            Tambah
          </Button>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Judul</TableHead>
                <TableHead>Kategori</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Urutan</TableHead>
                <TableHead className="w-24">Aksi</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {articles.length === 0 && (
                <TableRow>
                  <TableCell colSpan={5} className="text-center text-muted-foreground py-8">
                    Belum ada artikel wiki.
                  </TableCell>
                </TableRow>
              )}
              {articles.map((article) => (
                <TableRow key={article.id}>
                  <TableCell className="font-medium">{article.title}</TableCell>
                  <TableCell>{article.category?.name ?? "-"}</TableCell>
                  <TableCell>
                    {article.isPublished ? (
                      <Badge variant="default">Published</Badge>
                    ) : (
                      <Badge variant="secondary">Draft</Badge>
                    )}
                  </TableCell>
                  <TableCell>{article.order}</TableCell>
                  <TableCell>
                    <div className="flex items-center gap-1">
                      <Button size="icon-xs" variant="ghost">
                        <Pencil className="size-3.5" />
                      </Button>
                      <form action={deleteWikiArticle}>
                        <input type="hidden" name="id" value={article.id} />
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
