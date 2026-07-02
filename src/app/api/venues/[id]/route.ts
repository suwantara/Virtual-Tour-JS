import { NextRequest, NextResponse } from "next/server";
import { auth } from "@/lib/auth";
import { prisma } from "@/lib/prisma";
import { z } from "zod";

const updateVenueSchema = z.object({
  name: z.string().min(2).optional(),
  slug: z.string().min(2).optional(),
  categoryId: z.number().int().positive().nullable().optional(),
  description: z.string().nullable().optional(),
  isPublished: z.boolean().optional(),
  primaryColor: z.string().optional(),
  thumbnailPath: z.string().nullable().optional(),
  logoPath: z.string().nullable().optional(),
});

function parseId(raw: string) {
  const id = Number(raw);
  return Number.isNaN(id) ? null : id;
}

export async function GET(
  _request: NextRequest,
  { params }: { params: Promise<{ id: string }> }
) {
  const { id: idRaw } = await params;
  const id = parseId(idRaw);
  if (id === null) {
    return NextResponse.json({ error: "ID tidak valid." }, { status: 400 });
  }

  const venue = await prisma.venue.findUnique({
    where: { id },
    include: {
      category: { select: { name: true } },
      scenes: {
        where: { isPublished: true },
        orderBy: { order: "asc" },
      },
    },
  });

  if (!venue) {
    return NextResponse.json({ error: "Not found" }, { status: 404 });
  }

  return NextResponse.json(venue);
}

export async function PUT(
  request: NextRequest,
  { params }: { params: Promise<{ id: string }> }
) {
  const session = await auth();
  if (!session?.user) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  const { id: idRaw } = await params;
  const id = parseId(idRaw);
  if (id === null) {
    return NextResponse.json({ error: "ID tidak valid." }, { status: 400 });
  }

  try {
    const body = await request.json();
    const parsed = updateVenueSchema.safeParse(body);

    if (!parsed.success) {
      return NextResponse.json(
        { error: "Data tidak valid.", details: parsed.error.issues },
        { status: 422 }
      );
    }

    const { categoryId, ...data } = parsed.data;

    const venue = await prisma.venue.update({
      where: { id },
      data: {
        ...data,
        categoryId: categoryId ?? undefined,
      },
      include: { category: { select: { name: true } } },
    });

    return NextResponse.json(venue);
  } catch {
    return NextResponse.json(
      { error: "Terjadi kesalahan server." },
      { status: 500 }
    );
  }
}

export async function DELETE(
  _request: NextRequest,
  { params }: { params: Promise<{ id: string }> }
) {
  const session = await auth();
  if (!session?.user) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  const { id: idRaw } = await params;
  const id = parseId(idRaw);
  if (id === null) {
    return NextResponse.json({ error: "ID tidak valid." }, { status: 400 });
  }

  await prisma.venue.delete({ where: { id } });
  return NextResponse.json({ success: true });
}
