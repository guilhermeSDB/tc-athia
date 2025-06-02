import api from "@/lib/api";
import { useMutation, useQueryClient } from "@tanstack/react-query";

export function useDeleteSetor() {
	const queryClient = useQueryClient();

	return useMutation<
		void,
		Error,
		number
	>({
		mutationFn: async (id: number) => {
			await api.delete(`/setores/${id}`);
		},
		onSuccess: () => {
			queryClient.invalidateQueries({ queryKey: ["setores", "setores-count"] });
		},
	});
}
