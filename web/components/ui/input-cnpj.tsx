'use client'

import { Control, Controller, FieldValues, Path } from 'react-hook-form';
import { IMaskInput } from 'react-imask';

type CnpjInputProps<T extends FieldValues> = {
	control: Control<T>
	name: Path<T>
	label?: string
	required?: boolean
}

export function InputCNPJ<T extends FieldValues>({
	control,
	name,
}: CnpjInputProps<T>) {
	return (
		<div>
			<label className="block text-sm font-medium">CNPJ</label>
			<Controller
				name={name}
				control={control}
				render={({ field }) => (
					<IMaskInput
						{...field}
						mask="00.000.000/0000-00"
						radix="."
						unmask={false}
						className="file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm"
						placeholder="00.000.000/0000-00"
					/>
				)}
			/>
		</div>
	)
}
