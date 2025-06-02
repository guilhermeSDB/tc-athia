import { Badge } from "@/components/ui/badge"
import {
	Card,
	CardAction,
	CardDescription,
	CardFooter,
	CardHeader,
	CardTitle,
} from "@/components/ui/card"
import { useCountEmpresas } from "@/hooks/use-count-empresa"
import { useCountSetores } from "@/hooks/use-count-setor"
import { IconBuildingFactory2, IconLayoutGrid } from "@tabler/icons-react"
import CardSkeleton from "./skeleton-section-cards"

export function SectionCards() {
  const { data: empresas, isLoading: loadingEmpresas } = useCountEmpresas()
  const { data: setores, isLoading: loadingSetores } = useCountSetores()

	return (
    <div className="*:data-[slot=card]:from-primary/5 *:data-[slot=card]:to-card dark:*:data-[slot=card]:bg-card grid grid-cols-1 gap-4 px-4 *:data-[slot=card]:bg-gradient-to-t *:data-[slot=card]:shadow-xs lg:px-6 @xl/main:grid-cols-2 @5xl/main:grid-cols-4">
      {loadingEmpresas ? (
        <CardSkeleton />
      ) : (
        <Card className="@container/card">
          <CardHeader>
            <CardDescription>Total de Empresas</CardDescription>
            <CardTitle className="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
              {empresas?.count ?? 0}
            </CardTitle>
            <CardAction>
              <Badge variant="outline">
                <IconBuildingFactory2 className="mr-1" />
                Empresas
              </Badge>
            </CardAction>
          </CardHeader>
          <CardFooter className="flex-col items-start gap-1.5 text-sm">
            <div className="line-clamp-1 flex gap-2 font-medium">
              Dados consolidados
            </div>
            <div className="text-muted-foreground">
              Número total de empresas cadastradas
            </div>
          </CardFooter>
        </Card>
      )}

      {loadingSetores ? (
        <CardSkeleton />
      ) : (
        <Card className="@container/card">
          <CardHeader>
            <CardDescription>Total de Setores</CardDescription>
            <CardTitle className="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
              {setores?.count ?? 0}
            </CardTitle>
            <CardAction>
              <Badge variant="outline">
                <IconLayoutGrid className="mr-1" />
                Setores
              </Badge>
            </CardAction>
          </CardHeader>
          <CardFooter className="flex-col items-start gap-1.5 text-sm">
            <div className="line-clamp-1 flex gap-2 font-medium">
              Informações organizacionais
            </div>
            <div className="text-muted-foreground">
              Total de setores relacionados às empresas
            </div>
          </CardFooter>
        </Card>
      )}
    </div>
  )
}
