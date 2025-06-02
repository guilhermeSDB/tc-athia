import api from "@/lib/api";
import type { Empresa } from "@/types/empresa";
import { useQuery } from "@tanstack/react-query";

async function fetchEmpresa(id: number): Promise<Empresa> {
	const { data } = await api.get(`/empresas/${id}`);
	return data.data as unknown as Empresa;
}

export function useEmpresa(
	id: number,
	options?: { enabled?: boolean }
) {
	return useQuery<Empresa, Error>({
		queryKey: ["empresa", id],
		queryFn: fetchEmpresa.bind(null, id),
		enabled: !!id && (options?.enabled ?? true)
	});
}
