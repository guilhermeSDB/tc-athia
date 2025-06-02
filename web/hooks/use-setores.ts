import api from "@/lib/api";
import { Setor } from "@/types/setor";
import { useQuery } from "@tanstack/react-query";

async function fetchSetores(): Promise<Setor[]> {
	const { data } = await api.get("/setores");
  return data.data as Setor[];
}

export function useSetores() {
  return useQuery<Setor[], Error>({
    queryKey: ["setores"],
    queryFn: fetchSetores,
    staleTime: 1000 * 60 * 2,
  });
}
