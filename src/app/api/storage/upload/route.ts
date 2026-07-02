import { NextRequest, NextResponse } from "next/server";
import { auth } from "@/lib/auth";
import { uploadFile } from "@/lib/storage";
import { z } from "zod";

const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB

const uploadSchema = z.object({
  fileName: z.string().min(1),
  contentType: z.string().min(1),
});

export async function POST(request: NextRequest) {
  const session = await auth();
  if (!session?.user) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  try {
    const contentType = request.headers.get("content-type") || "";

    if (contentType.includes("multipart/form-data")) {
      const formData = await request.formData();
      const file = formData.get("file") as File | null;
      const prefix = (formData.get("prefix") as string) || "uploads";

      if (!file) {
        return NextResponse.json(
          { error: "File tidak ditemukan." },
          { status: 400 }
        );
      }

      if (file.size > MAX_FILE_SIZE) {
        return NextResponse.json(
          { error: "File terlalu besar. Maksimal 10MB." },
          { status: 400 }
        );
      }

      const buffer = Buffer.from(await file.arrayBuffer());
      const key = `${prefix}/${Date.now()}-${file.name}`;
      const url = await uploadFile(key, buffer, file.type);

      return NextResponse.json({ url, key }, { status: 201 });
    }

    const body = await request.json();
    const parsed = uploadSchema.safeParse(body);

    if (!parsed.success) {
      return NextResponse.json(
        { error: "Data tidak valid." },
        { status: 422 }
      );
    }

    const { fileName, contentType: fileType } = parsed.data;
    const buffer = Buffer.from(
      request.headers.get("x-file-base64") || "",
      "base64"
    );

    const key = `uploads/${Date.now()}-${fileName}`;
    const url = await uploadFile(key, buffer, fileType);

    return NextResponse.json({ url, key }, { status: 201 });
  } catch {
    return NextResponse.json(
      { error: "Upload gagal." },
      { status: 500 }
    );
  }
}
