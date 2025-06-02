"use client"

import RelatorioEmpresasSetores from "@/components/relatorio-empresas-setores";
import { SectionCards } from "@/components/section-cards";


export default function Page() {
	return (
		<>
			<SectionCards />
			<div className="px-4 lg:px-6">
				<RelatorioEmpresasSetores />
			</div>
		</>
	);
}
