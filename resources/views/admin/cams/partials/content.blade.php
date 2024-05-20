<div class="flex flex-col mt-6 my-4">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                ID
                            </th>

                            <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                Status
                            </th>

                            <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                Identificador
                            </th>

                            <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                Situação
                            </th>

                            <th scope="col" class="relative py-3.5 px-4">
                                <span class="sr-only">Ver</span>
                            </th>

                            <th scope="col" class="relative py-3.5 px-4">
                                <span class="sr-only">Ações</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                        @foreach ($cams->items() as $cam)
                        <tr>
                            <td class="px-4 py-2 text-sm font-medium whitespace-nowrap dark:text-white">
                                {{ $cam->id }}
                            </td>
                            <td class="px-12 py-2 text-sm font-medium whitespace-nowrap">
                                @if($cam->tpMan == 'Cadastramento')
                                <div class="inline px-3 py-1 text-sm font-normal rounded-full text-7-500 gap-x-2 bg-7-100/60">
                                    {{ $cam->tpMan }}
                                </div>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                {{ $cam->cEQP }}
                            </td>
                            <td class="px-4 py-2 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    {{ $cam->statusSend }}
                                </div>
                            </td>

                            <td class="px-4 py-2 text-sm whitespace-nowrap flex">

                                <a href="{{ route('cams.edit', $cam->id) }}" class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg">
                                    Editar
                                </a>
                                <a href="{{ route('cams.show', $cam->id) }}" class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                                    </svg>
                                </a>

                                <!--  -->
                            </td>

                            <td class="px-4 py-2 text-sm whitespace-nowrap">
                                <a href="{{  route('cams.send', $cam->id) }}" class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>

                                    <span>Enviar</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
