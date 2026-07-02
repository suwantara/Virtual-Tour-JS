import { NextRequest, NextResponse } from "next/server";
import { auth } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import { z } from "zod";

const createVenueSchema = z.object({
  name: z.string().min(2),
  slug: z.string().min(2),
  categoryId: z.number().int().positive().nullable().optional(),
  description: z.string().nullable().optional(),
  isPublished: z.boolean().optional(),
  primaryColor: z.string().optional(),
});

export async function GET() {
  const venues = await prisma.venue.findMany({
    include: { category: { select: { name: true } } },
    orderBy: { createdAt: "desc" },
  });
  return NextResponse.json(venues);
}

export async function POST(request: NextRequest) {
  const session = await auth();
  if (!session?.user) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  try {
    const body = await request.json();
    const parsed = createVenueSchema.safeParse(body);

    if (!parsed.success) {
      return NextResponse.json(
        { error: "Data tidak valid.", details: parsed.error.issues },
        { status: 422 }
      );
    }

    const { categoryId, ...data } = parsed.data;

    const venue = await prisma.venue.create({
      data: {
        ...data,
        categoryId: categoryId ?? null,
      },
      include: { category: { select: { name: true } } },
    });

    return NextResponse.json(venue, { status: 201 });
  } catch {
    return NextResponse.json(
      { error: "Terjadi kesalahan server." },
      { status: 500 }
    );
  }
}
