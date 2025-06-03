import api from "@/lib/api";
import { Setor } from "@/types/setor";
import { useMutation, useQueryClient } from "@tanstack/react-query";

export interface CreateSetorInput {
	descricao: string;
}

export function useCreateSetor() {
	const queryClient = useQueryClient();

	return useMutation<Setor, Error, CreateSetorInput>({
		mutationFn: async (payload) => {
			const { data } = await api.post<Setor>("/setores", payload);
			return data;
		},
		onSuccess: () => {
			queryClient.invalidateQueries({ queryKey: ["setores"] });
			queryClient.invalidateQueries({ queryKey: ["setores-count"] });
		},
	});
}
