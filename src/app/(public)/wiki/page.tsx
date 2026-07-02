import Link from "next/link";
import { prisma } from "@/lib/prisma";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";

export default async function WikiPage() {
  const categories = await prisma.wikiCategory.findMany({
    orderBy: { order: "asc" },
    include: {
      articles: {
        where: { isPublished: true },
        orderBy: { order: "asc" },
        select: { slug: true, title: true, excerpt: true },
      },
    },
  });

  return (
    <div className="bg-stone-950 text-stone-100 pt-24 pb-20">
      <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div className="mb-12">
          <h1 className="text-4xl font-bold tracking-tight">Wiki</h1>
          <p className="mt-3 text-stone-400 text-lg">
            Pengetahuan seputar Pura Desa Adat Tambawu, arsitektur, ritual, dan sejarah.
          </p>
        </div>

        {categories.length === 0 ? (
          <p className="text-stone-400 text-center py-20">
            Belum ada artikel tersedia.
          </p>
        ) : (
          <div className="space-y-12">
            {categories.map((category) => (
              <section key={category.id}>
                <h2 className="text-2xl font-semibold mb-6">{category.name}</h2>
                <div className="grid gap-4 sm:grid-cols-2">
                  {category.articles.map((article) => (
                    <Link key={article.slug} href={`/wiki/${article.slug}`}>
                      <Card className="h-full border-stone-800 bg-stone-900 hover:bg-stone-800/80 transition-colors">
                        <CardHeader>
                          <CardTitle className="text-stone-100">{article.title}</CardTitle>
                          {article.excerpt && (
                            <CardDescription className="text-stone-400 line-clamp-2">
                              {article.excerpt}
                            </CardDescription>
                          )}
                        </CardHeader>
                      </Card>
                    </Link>
                  ))}
                </div>
              </section>
            ))}
          </div>
        )}
      </div>
    </div>
  );
}
