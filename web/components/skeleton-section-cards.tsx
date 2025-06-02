import { Card, CardAction, CardDescription, CardFooter, CardHeader, CardTitle } from "./ui/card";
import { Skeleton } from "./ui/skeleton";

export default function CardSkeleton() {
 return (
    <Card className="@container/card animate-pulse">
      <CardHeader>
        <CardDescription>
          <Skeleton className="h-4 w-32" />
        </CardDescription>
        <CardTitle className="text-2xl font-semibold tabular-nums @[250px]/card:text-3xl">
          <Skeleton className="h-8 w-24" />
        </CardTitle>
        <CardAction>
          <Skeleton className="h-6 w-20 rounded-md" />
        </CardAction>
      </CardHeader>
      <CardFooter className="flex-col items-start gap-1.5 text-sm">
        <Skeleton className="h-4 w-40" />
        <Skeleton className="h-3 w-56" />
      </CardFooter>
    </Card>
  )
}
