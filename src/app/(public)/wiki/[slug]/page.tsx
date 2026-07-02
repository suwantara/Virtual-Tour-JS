import { notFound } from "next/navigation";
import Link from "next/link";
import { prisma } from "@/lib/prisma";
import { sanitize } from "@/lib/sanitize";

interface Props {
  params: Promise<{ slug: string }>;
}

export default async function WikiArticlePage({ params }: Props) {
  const { slug } = await params;

  const article = await prisma.wikiArticle.findUnique({
    where: { slug },
    include: {
      category: { select: { name: true, slug: true } },
    },
  });

  if (!article || !article.isPublished) {
    notFound();
  }

  return (
    <div className="bg-stone-950 text-stone-100 pt-24 pb-20">
      <article className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        {article.category && (
          <Link
            href={`/wiki#${article.category.slug}`}
            className="text-sm text-stone-400 hover:text-stone-200 transition-colors"
          >
            {article.category.name}
          </Link>
        )}

        <h1 className="mt-2 text-4xl font-bold tracking-tight">{article.title}</h1>

        {article.excerpt && (
          <p className="mt-4 text-lg text-stone-400">{article.excerpt}</p>
        )}

        <hr className="my-8 border-stone-800" />

        <div className="prose prose-invert prose-stone max-w-none">
          <div dangerouslySetInnerHTML={{ __html: sanitize(article.content) }} />
        </div>

        <hr className="my-12 border-stone-800" />

        <Link
          href="/wiki"
          className="text-sm text-stone-400 hover:text-stone-200 transition-colors"
        >
          &larr; Kembali ke Wiki
        </Link>
      </article>
    </div>
  );
}
