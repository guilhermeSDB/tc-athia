import api from "@/lib/api";
import { useQuery } from "@tanstack/react-query";

export type CountSetores = {
  count: number
}

async function fetchCountSetores(): Promise<CountSetores> {
  const { data } = await api.get("/setores/count");
  return data.data as CountSetores
}

export function useCountSetores() {
  return useQuery<CountSetores, Error>({
    queryKey: ["setores-count"],
    queryFn: fetchCountSetores,
    staleTime: 1000 * 60 * 2,
  });
}
