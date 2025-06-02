import {
	Card,
	CardContent,
	CardFooter,
	CardHeader,
	CardTitle,
} from "@/components/ui/card";
import { Skeleton } from "@/components/ui/skeleton";
import { EmpresaSetor } from "@/types/empresa-setor";
import { motion } from "framer-motion";
import { AlertCircle, Building2, Tags } from "lucide-react";
import { EmpresaDetalhesModal } from "./empresa-detalhes-modal";
import { EmpresaSetorChart } from "./empresa-setor-chart";
import { Setor } from "@/types/setor";

export default function RelatorioConteudo({ relatorio, isLoading }: { relatorio?: EmpresaSetor[], isLoading: boolean }) {
  if (isLoading) {
    return (
      <div className="space-y-4">
        {[1, 2, 3].map(i => (
          <div key={i} className="space-y-2">
            <Skeleton className="h-6 w-1/3" />
            <Skeleton className="h-4 w-1/2 ml-4" />
            <Skeleton className="h-4 w-1/4 ml-4" />
          </div>
        ))}
      </div>
    );
  }

  if (!relatorio || relatorio.length === 0) {
    return (
			<motion.div
				initial={{ opacity: 0, y: 10 }}
				animate={{ opacity: 1, y: 0 }}
				className="flex flex-col items-center justify-center text-center py-8 text-muted-foreground"
			>
				<AlertCircle className="w-10 h-10 text-gray-400 mb-2" />
				<h3 className="text-lg font-semibold">Nenhum resultado encontrado</h3>
				<p className="text-sm max-w-md">
					Não encontramos empresas para os filtros selecionados. Tente alterar os filtros e buscar novamente.
				</p>
			</motion.div>
    );
  }

  return (
		<motion.div
			initial={{ opacity: 0 }}
			animate={{ opacity: 1 }}
			className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
		>
			{relatorio.map((empresa) => (
				<Card
          key={empresa.id}
          className="border-l-4 border-blue-600 shadow-sm hover:shadow-lg transition-shadow duration-300"
        >
          <CardHeader className="flex flex-row items-center gap-2">
            <Building2 className="text-blue-600" size={20} />
            <CardTitle className="text-lg font-semibold text-blue-800">
              {empresa.razao_social}
            </CardTitle>
          </CardHeader>

          <CardContent>
            <ul className="list-disc list-inside text-sm text-muted-foreground space-y-1">
              {empresa.setores.map((setor: Setor) => (
                <li key={setor.id} className="flex items-center gap-1">
                  <Tags size={14} className="text-gray-500" />
                  {setor.descricao}
                </li>
              ))}
						</ul>
						
						<EmpresaSetorChart setores={empresa.setores} />
          </CardContent>

					<CardFooter className="mt-auto flex justify-end gap-2">
						<EmpresaDetalhesModal empresa={empresa} />
					</CardFooter>
        </Card>
      ))}
		</motion.div>
  );
}
