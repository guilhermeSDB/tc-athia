import api from "@/lib/api";
import { useMutation, useQueryClient } from "@tanstack/react-query";

export function useDeleteEmpresa() {
	const queryClient = useQueryClient();

	return useMutation<
		void,
		Error,
		number
	>({
		mutationFn: async (id: number) => {
			await api.delete(`/empresas/${id}`);
		},
		onSuccess: () => {
			queryClient.invalidateQueries({ queryKey: ["empresas"] });
			queryClient.invalidateQueries({ queryKey: ["empresas-count"] });
		},
	});
}
