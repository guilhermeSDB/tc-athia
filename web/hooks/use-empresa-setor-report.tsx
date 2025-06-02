import api from "@/lib/api";
import { EmpresaSetor } from "@/types/empresa-setor";
import { useQuery } from "@tanstack/react-query";

async function fetchEmpresasSetoresReport(empresaId?: number, setorId?: number): Promise<EmpresaSetor[]> {
  const { data } = await api.get("/empresas-setores/relatorio", {
    params: {
      empresa_id: empresaId,
      setor_id: setorId,
    },
  });
  return data.data as EmpresaSetor[];
}

export function useEmpresasSetoresReport(
	empresaId?: number,
	setorId?: number,
	options?: { enabled?: boolean }
) {
  return useQuery<EmpresaSetor[], Error>({
    queryKey: ["empresas-setores-report", empresaId, setorId],
    queryFn: () => fetchEmpresasSetoresReport(empresaId, setorId),
    staleTime: 1000 * 60 * 2,
		// enabled: empresaId !== undefined || setorId !== undefined,
  });
}


