import { Skeleton } from "./ui/skeleton";

export function EmpresasTableSkeleton() {
  return (
    <div className="space-y-4 p-6">
      <div className="flex justify-end mb-4">
        <Skeleton className="h-10 w-36 rounded-md" />
      </div>
      <table className="w-full table-auto border-collapse">
        <thead>
          <tr>
            {["ID", "CNPJ", "Razão Social", "Nome Fantasia", "Criado em", "Ações"].map((header) => (
              <th
                key={header}
                className="border-b border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-500"
              >
                {header}
              </th>
            ))}
          </tr>
        </thead>
        <tbody>
          {[...Array(5)].map((_, i) => (
            <tr key={i} className="border-b border-gray-200">
              {[...Array(6)].map((__, j) => (
                <td key={j} className="px-4 py-3">
                  <Skeleton className="h-4 max-w-[100px] rounded" />
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
