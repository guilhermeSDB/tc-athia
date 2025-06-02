import api from "@/lib/api";
import { useQuery } from "@tanstack/react-query";

export type CountEmpresas = {
  count: number
}

async function fetchCountEmpresas(): Promise<CountEmpresas> {
  const { data } = await api.get("/empresas/count");
  return data.data as CountEmpresas
}

export function useCountEmpresas() {
  return useQuery<CountEmpresas, Error>({
    queryKey: ["empresas-count"],
    queryFn: fetchCountEmpresas,
    staleTime: 1000 * 60 * 2,
  });
}




