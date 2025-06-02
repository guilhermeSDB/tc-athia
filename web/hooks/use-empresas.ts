import api from "@/lib/api";
import type { Empresa } from "@/types/empresa";
import { useQuery } from "@tanstack/react-query";

async function fetchEmpresas(): Promise<Empresa[]> {
  const { data } = await api.get("/empresas");
  return data.data as unknown as Empresa[];
}

export function useEmpresas() {
  return useQuery<Empresa[], Error>({
    queryKey: ["empresas"],
    queryFn: fetchEmpresas,
    staleTime: 1000 * 60 * 2, // 2 minutos
  });
}


