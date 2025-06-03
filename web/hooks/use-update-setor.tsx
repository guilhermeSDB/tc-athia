import api from "@/lib/api";
import type { Setor } from "@/types/setor";
import { useMutation, useQueryClient } from "@tanstack/react-query";

export interface UpdateSetorInput {
	id: number;
	descricao: string;
}

export function useUpdateSetor() {
	const queryClient = useQueryClient();

	return useMutation<Setor, Error, UpdateSetorInput>({
		mutationFn: async ({ id, ...rest }) => {
			const { data } = await api.put<Setor>(`/setores/${id}`, rest);
			return data;
		},
		onSuccess: (_, variables) => {
			queryClient.invalidateQueries({ queryKey: ["setores"] });
			queryClient.invalidateQueries({ queryKey: ["setores-count"] });
			queryClient.invalidateQueries({
				queryKey: ["setor", variables.id],
			});
		},
	});
}
