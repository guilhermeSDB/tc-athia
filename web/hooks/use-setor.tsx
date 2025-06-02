import api from "@/lib/api";
import type { Setor } from "@/types/setor";
import { useQuery } from "@tanstack/react-query";

export function useSetor(
	id: number,
	options?: { enabled?: boolean }
) {
	return useQuery<Setor, Error>({
		queryKey: ["setor", id],
		queryFn: async () => {
			const { data } = await api.get(`/setores/${id}`);
			return data.data as unknown as Setor
		},
		enabled: !!id && (options?.enabled ?? true)
	});
}
