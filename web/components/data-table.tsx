/* eslint-disable @typescript-eslint/no-explicit-any */
import {
	Table,
	TableBody,
	TableCell,
	TableHead,
	TableHeader,
	TableRow,
} from "@/components/ui/table";

type Column<T> = {
	key: keyof T | string;
	header: string;
	render?: (item: T) => React.ReactNode;
};

interface DataTableProps<T> {
	data: T[];
	columns: Column<T>[];
	emptyMessage?: string;
	actions?: (item: T) => React.ReactNode;
}

export function DataTable<T>({
	data,
	columns,
	emptyMessage = "Nenhum dado encontrado.",
	actions,
}: DataTableProps<T>) {
	return (
		<div className="w-full overflow-auto rounded-lg border">
			<Table>
				<TableHeader>
					<TableRow>
						{columns.map((col, idx) => (
							<TableHead key={idx}>{col.header}</TableHead>
						))}
						{actions && <TableHead>Ações</TableHead>}
					</TableRow>
				</TableHeader>
				<TableBody>
					{data.length === 0 ? (
						<TableRow>
							<TableCell colSpan={columns.length + (actions ? 1 : 0)} className="text-center h-24">
								{emptyMessage}
							</TableCell>
						</TableRow>
					) : (
						data.map((item, idx) => (
							<TableRow key={idx}>
								{columns.map((col, colIdx) => (
									<TableCell key={colIdx}>
										{col.render ? col.render(item) : (item as any)[col.key]}
									</TableCell>
								))}
								{actions && (
									<TableCell className="space-x-2">{actions(item)}</TableCell>
								)}
							</TableRow>
						))
					)}
				</TableBody>
			</Table>
		</div>
	);
}
