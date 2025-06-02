import api from "@/lib/api";
import type { Empresa } from "@/types/empresa";
import { useMutation, useQueryClient } from "@tanstack/react-query";

export interface UpdateEmpresaInput {
	id: number;
	cnpj: string;
	razao_social: string;
	nome_fantasia?: string;
}

export function useUpdateEmpresa() {
	const queryClient = useQueryClient();

	return useMutation<Empresa, Error, UpdateEmpresaInput>({
		mutationFn: async ({ id, ...rest }) => {
			const { data } = await api.put(`/empresas/${id}`, rest);
			return data.data as Empresa;
		},
		onSuccess: (_, variables) => {
			queryClient.invalidateQueries({ queryKey: ["empresas","empresas-count"] });
			queryClient.invalidateQueries({
				queryKey: ["empresa", variables.id],
			});
		},
	});
}
