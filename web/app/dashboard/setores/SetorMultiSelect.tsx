// components/SetorMultiSelect.tsx
"use client";

import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
import {
	Command,
	CommandEmpty,
	CommandGroup,
	CommandInput,
	CommandItem,
} from "@/components/ui/command";
import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from "@/components/ui/popover";
import { ScrollArea } from "@/components/ui/scroll-area";
import { motion } from "framer-motion";
import { ChevronsUpDown } from "lucide-react";
import React from "react";

type Setor = {
	id: number;
	descricao: string;
};

type SetorMultiSelectProps = {
	value: number[];
	options: Setor[];
	onChange: (value: number[]) => void;
	placeholder?: string;
};

export function SetorMultiSelect({
	value,
	options,
	onChange,
	placeholder = "Selecionar setores...",
}: SetorMultiSelectProps) {
	const [open, setOpen] = React.useState(false);

	const toggleOption = (id: number) => {
		if (value.includes(id)) {
			onChange(value.filter((v) => v !== id));
		} else {
			onChange([...value, id]);
		}
	};

	const selectedLabels = options
		.filter((option) => value.includes(option.id))
		.map((opt) => opt.descricao)
		.join(", ");

	const selectedCount = value.length;
	const displayText =
		selectedCount === 0
			? placeholder
			: selectedCount <= 3
			? selectedLabels
			: `${selectedCount} selecionados`;
	
	return (
		<Popover open={open} onOpenChange={setOpen}>
			<PopoverTrigger asChild>
				<Button
					variant="outline"
					role="combobox"
					className="w-full justify-between"
				>
					{displayText || placeholder}
					<ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
				</Button>
			</PopoverTrigger>
			<PopoverContent className="min-w-[300px] p-0 max-h-[300px] overflow-y-auto">
				<motion.div
					initial={{ opacity: 0, y: -10 }}
					animate={{ opacity: 1, y: 0 }}
					transition={{ duration: 0.2 }}
				>
					<Command>
						<CommandInput placeholder="Buscar setor..." />
						<CommandEmpty>Nenhum setor encontrado.</CommandEmpty>

						<ScrollArea className="max-h-[calc(100vh-200px)]">
							<CommandGroup heading="Setores disponíveis">
								{options.map((option) => (
									<CommandItem
										key={option.id}
										onSelect={() => toggleOption(option.id)}
										className="flex items-center justify-between"
									>
										<span>{option.descricao}</span>
										<Checkbox checked={value.includes(option.id)} />
									</CommandItem>
								))}
							</CommandGroup>
						</ScrollArea>
					</Command>
				</motion.div>
			</PopoverContent>
		</Popover>
	);
}
