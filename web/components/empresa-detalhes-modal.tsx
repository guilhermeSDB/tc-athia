import { Button } from "@/components/ui/button";
import {
	Dialog,
	DialogContent,
	DialogDescription,
	DialogHeader,
	DialogTitle,
	DialogTrigger,
} from "@/components/ui/dialog";
import { EmpresaSetor } from "@/types/empresa-setor";
import { Setor } from "@/types/setor";
import { Building2, Tags } from "lucide-react";

export function EmpresaDetalhesModal({ empresa }: { empresa: EmpresaSetor }) {
  return (
    <Dialog>
      <DialogTrigger asChild>
        <Button size="sm" variant="outline">
          Ver Detalhes
        </Button>
      </DialogTrigger>

      <DialogContent className="max-w-lg">
        <DialogHeader>
          <DialogTitle className="flex items-center gap-2 text-lg">
            <Building2 size={20} className="text-blue-600" />
            {empresa.razao_social}
          </DialogTitle>
          <DialogDescription>CNPJ: {empresa.cnpj ?? "Não informado"}</DialogDescription>
        </DialogHeader>

        <div className="mt-4 space-y-2">
          <h4 className="text-sm font-medium text-muted-foreground">Setores:</h4>
          <ul className="list-disc list-inside text-sm text-gray-700">
            {empresa.setores.map((setor: Setor) => (
              <li key={setor.id} className="flex items-center gap-1">
                <Tags size={14} className="text-gray-500" />
                {setor.descricao ?? "Setor sem nome"}
              </li>
            ))}
          </ul>
        </div>
      </DialogContent>
    </Dialog>
  );
}
