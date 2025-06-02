import api from "@/lib/api";
import { Empresa } from "@/types/empresa";
import { useMutation, useQueryClient } from "@tanstack/react-query";

export interface CreateEmpresaInput {
	cnpj: string;
	razao_social: string;
	nome_fantasia?: string;
}

export function useCreateEmpresa() {
	const queryClient = useQueryClient();

	return useMutation<Empresa, Error, CreateEmpresaInput>({
		mutationFn: async (payload) => {
			const { data } = await api.post("/empresas", payload);
			return data.data as Empresa;
		},
		onSuccess: () => {
			queryClient.invalidateQueries({ queryKey: ["empresas","empresas-count"] });
		},
	});
}
