import { revalidatePath } from "next/cache";
import { redirect } from "next/navigation";
import { prisma } from "@/lib/prisma";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Save, Trash2 } from "lucide-react";

async function updateSetting(formData: FormData) {
  "use server";
  const id = parseInt(formData.get("id") as string);
  const value = formData.get("value") as string;
  await prisma.siteSetting.update({ where: { id }, data: { value } });
  revalidatePath("/dashboard/settings");
}

async function deleteSetting(formData: FormData) {
  "use server";
  const id = parseInt(formData.get("id") as string);
  try {
    await prisma.siteSetting.delete({ where: { id } });
  } catch {
    redirect("/dashboard/settings?error=Gagal+menghapus+data.+Data+mungkin+masih+digunakan.");
  }
  revalidatePath("/dashboard/settings");
}

export default async function SettingsPage() {
  const settings = await prisma.siteSetting.findMany({
    orderBy: { key: "asc" },
  });

  return (
    <div>
      <h1 className="text-2xl font-bold tracking-tight mb-6">
        Pengaturan Situs
      </h1>

      <Card>
        <CardHeader>
          <CardTitle>Site Settings</CardTitle>
        </CardHeader>
        <CardContent>
          {settings.length === 0 && (
            <p className="text-center text-muted-foreground py-8">
              Belum ada pengaturan.
            </p>
          )}
          {settings.map((setting) => (
            <div
              key={setting.id}
              className="flex items-end gap-4 py-3 border-b last:border-0"
            >
              <form action={updateSetting} className="flex items-end gap-4 flex-1 min-w-0">
                <input type="hidden" name="id" value={setting.id} />
                <div className="flex-1 min-w-0">
                  <Label className="mb-1 block text-xs font-medium text-muted-foreground uppercase tracking-wider">
                    {setting.key}
                  </Label>
                  <Input
                    name="value"
                    defaultValue={setting.value ?? ""}
                    className="font-mono text-sm"
                  />
                </div>
                <Button type="submit" size="sm" variant="default">
                  <Save className="size-3.5" />
                  Simpan
                </Button>
              </form>
              <form action={deleteSetting}>
                <input type="hidden" name="id" value={setting.id} />
                <Button size="sm" variant="destructive" type="submit">
                  <Trash2 className="size-3.5" />
                </Button>
              </form>
            </div>
          ))}
        </CardContent>
      </Card>
    </div>
  );
}
