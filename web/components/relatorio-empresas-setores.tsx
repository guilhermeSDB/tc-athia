import { useEmpresasSetoresReport } from "@/hooks/use-empresa-setor-report";
import { useEmpresas } from "@/hooks/use-empresas";
import { useSetores } from "@/hooks/use-setores";
import { useMemo, useState } from "react";
import ExportCSVButton from "./csv-button";
import { EmpresaSelect } from "./empresa-select";
import RelatorioConteudo from "./relatorio-conteudo";
import { SetorSelect } from "./setor-select";
import { Button } from "./ui/button";

export default function RelatorioEmpresasSetores() {
  const [empresaId, setEmpresaId] = useState<number>();
  const [setorId, setSetorId] = useState<number>();
  const {data: empresas} = useEmpresas()
	const { data: setores } = useSetores()

	const { data: relatorio, isLoading } =
		useEmpresasSetoresReport(empresaId, setorId);
	
  const dadosCSV = useMemo(() => {
    if (!relatorio) return [];
    return relatorio.flatMap((empresa) =>
      empresa.setores.map((setor) => ({
        Empresa: empresa.razao_social,
        Setor: setor.descricao,
      }))
    );
	}, [relatorio]);
	
  const limparFiltros = () => {
    setEmpresaId(undefined);
    setSetorId(undefined);
  };

  return (
		<div className="space-y-4">
      <ExportCSVButton
        data={dadosCSV}
        filename="relatorio-empresas-setores.csv"
        disabled={!dadosCSV.length}
      />
			
     <div className="flex items-end gap-4">
        <div className="flex gap-4">
          <EmpresaSelect
            value={empresaId}
            onChange={(value: string) =>
              setEmpresaId(value ? Number(value) : undefined)
            }
            empresas={empresas}
          />
          <SetorSelect
            value={setorId}
            onChange={(value: string) =>
              setSetorId(value ? Number(value) : undefined)
            }
            setores={setores}
          />
        </div>

        <Button
          variant="outline"
          size="sm"
          onClick={limparFiltros}
        >
          Limpar filtros
        </Button>
      </div>

			<div className="border rounded-md p-4 min-h-[150px]">
				<RelatorioConteudo relatorio={relatorio} isLoading={isLoading} />
			</div>
    </div>
  );
};
